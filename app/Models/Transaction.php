<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_type',
        'amount',
        'status',
        'payment_details',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'json',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Menghasilkan ID transaksi unik
    public static function generateTransactionId()
    {
        $prefix = 'TRX-';
        $date = now()->format('Ymd');
        $randomNumber = mt_rand(10000, 99999);
        
        return $prefix . $date . $randomNumber;
    }
}