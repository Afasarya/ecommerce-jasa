<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;

use Illuminate\Routing\Controller as BaseController;

class TransactionController extends BaseController
{
    protected $midtransService;
    
    public function __construct(MidtransService $midtransService)
    {
        $this->middleware('auth')->except(['notification']);
        $this->midtransService = $midtransService;
    }
    
    /**
     * Display payment page for a transaction
     */
    public function pay($id)
    {
        try {
            $transaction = Transaction::with('order.user', 'order.items')
                ->where('id', $id)
                ->where('status', 'pending')
                ->whereHas('order', function($q) {
                    $q->where('user_id', auth()->id());
                })
                ->firstOrFail();
                
            $order = $transaction->order;
            
            Log::info('Processing payment for transaction: ' . $transaction->transaction_id);
            
            // Prepare transaction parameters for Midtrans
            $params = $this->midtransService->createTransactionParams($transaction, $order);
            
            // Create Snap Token
            $snapToken = $this->midtransService->createSnapToken($params);
            Log::info('Successfully generated Snap token for transaction: ' . $transaction->id);
            
            return view('transactions.pay', compact('transaction', 'order', 'snapToken'));
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            if (isset($order)) {
                return redirect()->route('orders.show', $order->order_number)
                    ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
            } else {
                return redirect()->route('orders.index')
                    ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * Handle transaction finish (redirect from Midtrans)
     */
    public function finish(Request $request, $id)
    {
        $transaction = Transaction::with('order')
            ->findOrFail($id);
            
        // Log incoming data for debugging
        Log::info('Transaction finish callback received', $request->all());
        
        // If payment finishes with response from Midtrans
        if ($request->has('transaction_status')) {
            try {
                $transactionStatus = $request->transaction_status;
                $paymentType = $request->payment_type;
                $fraudStatus = $request->fraud_status ?? null;
                
                // Update transaction based on Midtrans response
                $transaction->payment_type = $paymentType;
                $transaction->payment_details = $request->all();
                
                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'challenge') {
                        $transaction->status = 'pending';
                    } else if ($fraudStatus == 'accept') {
                        $transaction->status = 'success';
                        $transaction->paid_at = now();
                        
                        // Update order status to processing
                        $transaction->order->update(['status' => 'processing']);
                    }
                } else if ($transactionStatus == 'settlement') {
                    $transaction->status = 'success';
                    $transaction->paid_at = now();
                    $transaction->order->update(['status' => 'processing']);
                } else if (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                    $transaction->status = 'failed';
                } else if ($transactionStatus == 'pending') {
                    $transaction->status = 'pending';
                } else if ($transactionStatus == 'refund') {
                    $transaction->status = 'refunded';
                }
                
                $transaction->save();
                
                if ($transaction->status == 'success') {
                    return redirect()->route('orders.show', $transaction->order->order_number)
                        ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
                }
            } catch (\Exception $e) {
                Log::error('Error processing transaction finish: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('orders.show', $transaction->order->order_number)
            ->with('info', 'Terima kasih telah menggunakan layanan kami.');
    }
    
    /**
     * Handle Midtrans notification (webhook)
     */
    public function notification(Request $request)
    {
        try {
            $notificationBody = $request->getContent();
            
            // Log notification for debugging
            Log::info('Midtrans Notification: ' . $notificationBody);
            
            // Process notification
            $result = $this->midtransService->processNotification($notificationBody);
            
            // Find transaction in our database
            $transaction = Transaction::where('transaction_id', $result['transaction_id'])->first();
            
            if (!$transaction) {
                Log::error('Transaction not found for notification: ' . $result['transaction_id']);
                return response()->json(['message' => 'Transaction not found'], 404);
            }
            
            // Update transaction
            $transaction->payment_type = $result['payment_type'];
            $transaction->payment_details = $result['details'];
            $transaction->status = $result['status'];
            
            if ($result['status'] == 'success') {
                $transaction->paid_at = now();
                $transaction->order->update(['status' => 'processing']);
            }
            
            $transaction->save();
            
            return response()->json(['message' => 'Notification processed successfully']);
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans notification: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
    
    /**
     * Check transaction status manually from Midtrans
     */
    public function check($id)
    {
        try {
            $transaction = Transaction::with('order')
                ->findOrFail($id);
                
            if ($transaction->status != 'pending') {
                return redirect()->route('orders.show', $transaction->order->order_number)
                    ->with('info', 'Status pembayaran sudah diperbarui sebelumnya.');
            }
            
            // Get transaction status from Midtrans
            $result = $this->midtransService->getTransactionStatus($transaction->transaction_id);
            
            // Update transaction
            $transaction->payment_type = $result['payment_type'] ?? $transaction->payment_type;
            $transaction->payment_details = $result['details'];
            $transaction->status = $result['status'];
            
            if ($result['status'] == 'success') {
                $transaction->paid_at = now();
                $transaction->order->update(['status' => 'processing']);
                
                $message = 'Pembayaran berhasil diverifikasi!';
            } else if ($result['status'] == 'pending') {
                $message = 'Pembayaran masih menunggu.';
            } else {
                $message = 'Pembayaran gagal atau dibatalkan.';
            }
            
            $transaction->save();
            
            return redirect()->route('orders.show', $transaction->order->order_number)
                ->with('info', $message);
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Terjadi kesalahan saat memeriksa status transaksi: ' . $e->getMessage());
        }
    }
}