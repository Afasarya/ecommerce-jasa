<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'order_id',
        'rating',
        'comment',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_published' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope untuk review yang dipublikasikan
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}