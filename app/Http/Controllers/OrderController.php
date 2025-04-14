<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function checkout()
    {
        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('services.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }
        
        return view('orders.checkout', compact('cart'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);
        
        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('services.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }
        
        try {
            DB::beginTransaction();
            
            // Buat order dari keranjang
            $order = Order::createFromCart($cart, $request->notes);
            
            // Buat transaksi pembayaran
            $transaction = Transaction::create([
                'order_id' => $order->id,
                'transaction_id' => Transaction::generateTransactionId(),
                'amount' => $order->total_amount,
                'status' => 'pending',
            ]);
            
            DB::commit();
            
            // Redirect ke halaman pembayaran
            return redirect()->route('transaction.pay', $transaction->id)
                ->with('success', 'Pesanan berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('items', 'transaction')
            ->latest()
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }
    
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items.service', 'transaction'])
            ->firstOrFail();
            
        return view('orders.show', compact('order'));
    }
}
