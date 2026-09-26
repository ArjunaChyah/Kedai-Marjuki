<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /* ========================================================================= */
    /* [KATALOG MENU] - Daftar Semua Menu, Pencarian & Filter Harga               */
    /* ========================================================================= */
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with(['category', 'reviews']);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Fitur Pengurutan Harga (Termurah / Termahal / Abjad)
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return view('user.products.index', compact('products', 'categories'));
    }

    /* ========================================================================= */
    /* [DETAIL MENU & ULASAN] - Tampilan Rincian Menu & Testimoni Pelanggan       */
    /* ========================================================================= */
    public function show(string $slug)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->first();

        if (!$product) {
            // Cocokkan berdasarkan slug konversi nama
            $product = Product::with('category')->get()->first(function ($p) use ($slug) {
                return Str::slug($p->name) === $slug;
            });
        }

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Auto repair slug jika kosong
        if (empty($product->slug)) {
            $product->slug = Str::slug($product->name);
            $product->save();
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'available')
            ->take(4)
            ->get();

        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}
