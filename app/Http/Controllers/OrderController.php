<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }
        
        return view('orders.checkout', compact('cart'));
    }
    
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|string|in:midtrans',
        ]);
        
        // Get user cart
        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }
        
        try {
            // Begin database transaction
            DB::beginTransaction();
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORDER-' . date('Ymd') . strtoupper(Str::random(6)),
                'status' => 'pending',
                'total_amount' => $cart->total,
                'notes' => $request->notes,
                'user_phone' => $request->phone,
            ]);
            
            // Add order items from cart
            foreach ($cart->items as $cartItem) {
                $order->items()->create([
                    'service_id' => $cartItem->service_id,
                    'service_name' => $cartItem->service->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'notes' => $cartItem->notes,
                ]);
            }
            
            // Create transaction
            $transaction = Transaction::create([
                'order_id' => $order->id,
                'transaction_id' => 'TRX-' . date('Ymd') . rand(1000, 9999),
                'amount' => $order->total_amount,
                'status' => 'pending',
                'payment_type' => $request->payment_method,
            ]);
            
            // Clear the cart
            $cart->clear();
            
            DB::commit();
            
            // Redirect to payment page
            return redirect()->route('transaction.pay', $transaction->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            
            return redirect()->route('checkout')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
