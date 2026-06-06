<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'description', 'specifications',
        'price', 'stock', 'unit', 'image', 'weight', 'material', 'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'egrek'           => 'Egrek',
            'dodos'           => 'Dodos',
            'telescopic_pole' => 'Gagang Teleskopik',
            default           => ucfirst($this->category),
        };
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->stock > 0;
    }
}
