<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Menu Kedai',
            'slug' => 'menu-kedai',
        ]);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->stock > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format($this->price ?? 0, 0, ',', '.');
    }
}
