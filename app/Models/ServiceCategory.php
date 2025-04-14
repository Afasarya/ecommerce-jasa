<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ServiceCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')
            ->singleFile();
    }

    // Scope untuk kategori yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}