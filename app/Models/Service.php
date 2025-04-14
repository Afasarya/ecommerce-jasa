<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'discounted_price',
        'delivery_time',
        'what_you_get',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'what_you_get' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(ServiceReview::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile();
            
        $this->addMediaCollection('gallery');
    }

    // Menghitung rating rata-rata
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    // Mendapatkan harga yang ditampilkan (diskon jika ada)
    public function getDisplayPriceAttribute()
    {
        return $this->discounted_price ?? $this->price;
    }

    // Scope untuk layanan yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk layanan yang difeaturkan
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
