<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Menghitung total harga keranjang
    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    // Menghitung jumlah item di keranjang
    public function getItemCountAttribute()
    {
        return $this->items->sum('quantity');
    }

    // Menambahkan item ke keranjang
    public function addItem($serviceId, $quantity = 1, $notes = null)
    {
        $service = Service::findOrFail($serviceId);
        $price = $service->display_price;

        $existingItem = $this->items()->where('service_id', $serviceId)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'notes' => $notes ?? $existingItem->notes,
            ]);
            return $existingItem;
        }

        return $this->items()->create([
            'service_id' => $serviceId,
            'quantity' => $quantity,
            'price' => $price,
            'notes' => $notes,
        ]);
    }

    // Mengupdate item di keranjang
    public function updateItem($cartItemId, $quantity, $notes = null)
    {
        $item = $this->items()->findOrFail($cartItemId);
        
        $item->update([
            'quantity' => $quantity,
            'notes' => $notes ?? $item->notes,
        ]);

        return $item;
    }

    // Menghapus item dari keranjang
    public function removeItem($cartItemId)
    {
        return $this->items()->where('id', $cartItemId)->delete();
    }

    // Mengosongkan keranjang
    public function clear()
    {
        return $this->items()->delete();
    }
}