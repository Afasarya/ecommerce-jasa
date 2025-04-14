<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Exception;

class MidtransService
{
    /**
     * Create Snap Token for payment
     *
     * @param array $params
     * @return string
     */
    public function createSnapToken(array $params): string
    {
        try {
            // Ensure server key is set
            if (empty(Config::$serverKey)) {
                throw new Exception('Midtrans server key is not set');
            }
            
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            report($e);
            throw new Exception('Error creating Midtrans Snap Token: ' . $e->getMessage());
        }
    }
    
    /**
     * Create payment transaction parameters
     *
     * @param \App\Models\Transaction $transaction
     * @param \App\Models\Order $order
     * @return array
     */
    public function createTransactionParams($transaction, $order): array
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_id,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'item_details' => [],
            'enabled_payments' => config('midtrans.enabled_payments'),
            'expiry' => [
                'unit' => config('midtrans.expiry.unit', 'minutes'),
                'duration' => config('midtrans.expiry.duration', 1440), // 24 hours by default
            ],
            'callbacks' => [
                'finish' => route('transaction.finish', $transaction->id),
                'unfinish' => route('transaction.finish', $transaction->id),
                'error' => route('transaction.finish', $transaction->id),
            ],
        ];
        
        // Add order items to transaction parameters
        foreach ($order->items as $item) {
            $params['item_details'][] = [
                'id' => $item->service_id,
                'name' => $item->service_name,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
            ];
        }
        
        return $params;
    }
    
    /**
     * Process notification from Midtrans
     *
     * @param string $notificationBody
     * @return array
     */
    public function processNotification(string $notificationBody): array
    {
        try {
            $notification = new Notification();
            
            $transactionStatus = $notification->transaction_status;
            $transactionId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;
            
            $statusResult = [
                'transaction_id' => $transactionId,
                'status' => 'pending',
                'payment_type' => $paymentType,
                'details' => json_decode($notificationBody, true),
            ];
            
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    // Transaction is challenged by FDS
                    $statusResult['status'] = 'pending';
                } else if ($fraudStatus == 'accept') {
                    // Transaction is not fraud
                    $statusResult['status'] = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                // Transaction is completed
                $statusResult['status'] = 'success';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                // Transaction is denied, cancelled or expired
                $statusResult['status'] = 'failed';
            } else if ($transactionStatus == 'pending') {
                // Transaction is pending
                $statusResult['status'] = 'pending';
            } else if ($transactionStatus == 'refund') {
                // Transaction is refunded
                $statusResult['status'] = 'refunded';
            }
            
            return $statusResult;
        } catch (Exception $e) {
            report($e);
            throw new Exception('Error processing Midtrans notification: ' . $e->getMessage());
        }
    }
    
    /**
     * Get transaction status from Midtrans
     *
     * @param string $transactionId
     * @return array
     */
    public function getTransactionStatus(string $transactionId): array
    {
        try {
            $response = json_decode(json_encode(Transaction::status($transactionId)));
            return [
                'transaction_id' => $transactionId,
                'status' => $this->mapTransactionStatus($response->transaction_status, $response->fraud_status ?? null),
                'payment_type' => $response->payment_type ?? null,
                'details' => json_decode(json_encode($response), true),
            ];
        } catch (Exception $e) {
            report($e);
            throw new Exception('Error getting transaction status: ' . $e->getMessage());
        }
    }
    
    /**
     * Map transaction status from Midtrans to our application status
     *
     * @param string $transactionStatus
     * @param string|null $fraudStatus
     * @return string
     */
    private function mapTransactionStatus(string $transactionStatus, ?string $fraudStatus): string
    {
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                return 'pending';
            } else if ($fraudStatus == 'accept') {
                return 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            return 'success';
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            return 'failed';
        } else if ($transactionStatus == 'pending') {
            return 'pending';
        } else if ($transactionStatus == 'refund') {
            return 'refunded';
        }
        
        return 'pending';
    }
}