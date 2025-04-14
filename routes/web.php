<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

// Layanan
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/category/{slug}', [ServiceController::class, 'categoryShow'])->name('services.category');

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profil (default dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout & Order
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    
    // Pembayaran
    Route::get('/pay/{id}', [TransactionController::class, 'pay'])->name('transaction.pay');
    Route::get('/transaction/{id}/finish', [TransactionController::class, 'finish'])->name('transaction.finish');
    
    // Review Layanan
    Route::post('/reviews', [ServiceReviewController::class, 'store'])->name('reviews.store');
    
    // Dashboard Pengguna
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('index');
        Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
        Route::get('/reviews', [UserDashboardController::class, 'reviews'])->name('reviews');
        Route::get('/settings', [UserDashboardController::class, 'settings'])->name('settings');
        Route::patch('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/password', [UserDashboardController::class, 'updatePassword'])->name('password.update');
    });
});

// Webhook untuk notifikasi pembayaran
Route::post('payment-notification', [TransactionController::class, 'notification'])->name('payment.notification');

require __DIR__.'/auth.php';