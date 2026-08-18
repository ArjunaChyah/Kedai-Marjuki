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

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (Str::startsWith($this->image, 'http')) {
                return $this->image;
            }
            if (file_exists(public_path('foto_website/' . $this->image))) {
                return asset('foto_website/' . $this->image);
            }
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }

        // Auto-detect matching image file in public/foto_website/produk/
        $slug = $this->slug ?: Str::slug($this->name);
        $cleanName = str_replace('-', '', $slug);

        $possibleFiles = [
            "produk/{$slug}.jpg",
            "produk/{$slug}.png",
            "produk/{$slug}.jpeg",
            "produk/{$cleanName}.jpg",
            "produk/{$cleanName}.png",
            "{$slug}.jpg",
            "{$slug}.png",
        ];

        foreach ($possibleFiles as $file) {
            if (file_exists(public_path('foto_website/' . $file))) {
                return asset('foto_website/' . $file);
            }
        }

        return asset('foto_website/etalase.jpg');
    }
}
