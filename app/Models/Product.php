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

        $slug = $this->slug ?: Str::slug($this->name);
        $cleanName = str_replace('-', '', $slug);

        // Spelling variations (telor <-> telur, indomie-telor <-> indomie)
        $variations = [
            $slug,
            $cleanName,
            str_replace('telor', 'telur', $slug),
            str_replace('telur', 'telor', $slug),
            str_replace('telor', 'telur', $cleanName),
            str_replace('telur', 'telor', $cleanName),
            explode('-', $slug)[0], // e.g. 'indomie' from 'indomie-telor'
            explode('-', $slug)[1] ?? '',
        ];

        $extensions = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($variations as $var) {
            if (empty($var)) continue;
            foreach ($extensions as $ext) {
                $checkPaths = [
                    "foto_website/produk/{$var}.{$ext}",
                    "foto_website/{$var}.{$ext}",
                ];
                foreach ($checkPaths as $p) {
                    if (file_exists(public_path($p))) {
                        return asset($p);
                    }
                }
            }
        }

        // Fuzzy match: scan files in public/foto_website/produk/
        $produkDir = public_path('foto_website/produk');
        if (is_dir($produkDir)) {
            $files = scandir($produkDir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $fileBase = strtolower(pathinfo($file, PATHINFO_FILENAME));
                $primaryWord = explode('-', $slug)[0];
                if (str_contains($slug, $fileBase) || str_contains($fileBase, $primaryWord)) {
                    return asset('foto_website/produk/' . $file);
                }
            }
        }

        return asset('foto_website/etalase.jpg');
    }
}
