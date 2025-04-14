<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'service_id',
        'service_name',
        'quantity',
        'price',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Menghitung subtotal item
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    // Cek apakah sudah di-review
    public function hasBeenReviewed()
    {
        return ServiceReview::where('order_id', $this->order_id)
            ->where('service_id', $this->service_id)
            ->exists();
    }
}
