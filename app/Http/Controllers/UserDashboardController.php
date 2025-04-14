<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ServiceReview;

use Illuminate\Routing\Controller;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $recentOrders = auth()->user()->orders()
            ->with('transaction')
            ->latest()
            ->take(5)
            ->get();
            
        $activeOrders = auth()->user()->orders()
            ->where('status', 'processing')
            ->count();
            
        $completedOrders = auth()->user()->orders()
            ->where('status', 'completed')
            ->count();
            
        $totalSpent = auth()->user()->orders()
            ->whereHas('transaction', function($q) {
                $q->where('status', 'success');
            })
            ->sum('total_amount');
            
        return view('dashboard.index', compact(
            'recentOrders',
            'activeOrders',
            'completedOrders',
            'totalSpent'
        ));
    }
    
    public function orders()
    {
        $pendingOrders = auth()->user()->orders()
            ->with('transaction')
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        $processingOrders = auth()->user()->orders()
            ->with('transaction')
            ->where('status', 'processing')
            ->latest()
            ->get();
            
        $completedOrders = auth()->user()->orders()
            ->with('transaction')
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();
            
        $cancelledOrders = auth()->user()->orders()
            ->with('transaction')
            ->where('status', 'cancelled')
            ->latest()
            ->take(5)
            ->get();
            
        return view('dashboard.orders', compact(
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }
    
    public function reviews()
    {
        $userReviews = auth()->user()->reviews()
            ->with(['service', 'order'])
            ->latest()
            ->paginate(10);
            
        // Pesanan yang selesai tapi belum direview
        $pendingReviews = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereDoesntHave('reviews')
            ->with(['items.service'])
            ->latest()
            ->get();
            
        return view('dashboard.reviews', compact('userReviews', 'pendingReviews'));
    }
    
    public function settings()
    {
        return view('dashboard.settings');
    }
    
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return back()->with('success', 'Profil berhasil diperbarui');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);
        
        return back()->with('success', 'Password berhasil diperbarui');
    }
}