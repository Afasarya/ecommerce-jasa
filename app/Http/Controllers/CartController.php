<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Service;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
        
        return view('cart.index', compact('cart'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $service = Service::findOrFail($request->service_id);
        
        // Pastikan layanan aktif
        if (!$service->is_active) {
            return back()->with('error', 'Layanan ini tidak tersedia.');
        }
        
        // Dapatkan keranjang user atau buat baru jika belum ada
        $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
        
        // Tambahkan item ke keranjang
        $cart->addItem(
            $request->service_id,
            $request->quantity,
            $request->notes
        );
        
        return redirect()->route('cart.index')->with('success', 'Layanan berhasil ditambahkan ke keranjang.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $cart = auth()->user()->cart;
        
        if (!$cart) {
            return redirect()->route('cart.index');
        }
        
        $cart->updateItem(
            $id,
            $request->quantity,
            $request->notes
        );
        
        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }
    
    public function remove($id)
    {
        $cart = auth()->user()->cart;
        
        if (!$cart) {
            return redirect()->route('cart.index');
        }
        
        $cart->removeItem($id);
        
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
    public function clear()
    {
        $cart = auth()->user()->cart;
        
        if ($cart) {
            $cart->clear();
        }
        
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
