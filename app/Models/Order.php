<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(ServiceReview::class);
    }

    // Generate nomor pesanan unik
    public static function generateOrderNumber()
    {
        $prefix = 'CC-';
        $date = now()->format('Ymd');
        $randomNumber = mt_rand(1000, 9999);
        
        return $prefix . $date . $randomNumber;
    }

    // Membuat pesanan dari keranjang
    public static function createFromCart(Cart $cart, $notes = null)
    {
        // Pastikan keranjang tidak kosong
        if ($cart->items->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $order = self::create([
            'order_number' => self::generateOrderNumber(),
            'user_id' => $cart->user_id,
            'total_amount' => $cart->total,
            'status' => 'pending',
            'notes' => $notes,
        ]);

        // Salin item keranjang ke item pesanan
        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'service_id' => $cartItem->service_id,
                'service_name' => $cartItem->service->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'notes' => $cartItem->notes,
            ]);
        }

        // Kosongkan keranjang setelah pesanan dibuat
        $cart->clear();

        return $order;
    }
}