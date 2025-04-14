<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use App\Models\OrderItem;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class ServiceReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'service_id' => 'required|exists:services,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);
        
        // Pastikan user memiliki order ini
        $orderItem = OrderItem::where('order_id', $validatedData['order_id'])
            ->where('service_id', $validatedData['service_id'])
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->id())
                      ->where('status', 'completed');
            })
            ->firstOrFail();
            
        // Pastikan layanan ini belum direview untuk order ini
        $existingReview = ServiceReview::where('order_id', $validatedData['order_id'])
            ->where('service_id', $validatedData['service_id'])
            ->where('user_id', auth()->id())
            ->first();
            
        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk layanan ini.');
        }
        
        // Simpan review
        ServiceReview::create([
            'service_id' => $validatedData['service_id'],
            'order_id' => $validatedData['order_id'],
            'user_id' => auth()->id(),
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment'] ?? null,
            'is_published' => true,
        ]);
        
        return redirect()->back()->with('success', 'Review anda berhasil disimpan.');
    }
}