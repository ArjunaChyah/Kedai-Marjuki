<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->first();

        if (!$product) {
            // Try matching by converted slug from name
            $product = Product::with('category')->get()->first(function ($p) use ($slug) {
                return Str::slug($p->name) === $slug;
            });
        }

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Auto repair slug if missing
        if (empty($product->slug)) {
            $product->slug = Str::slug($product->name);
            $product->save();
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'available')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
