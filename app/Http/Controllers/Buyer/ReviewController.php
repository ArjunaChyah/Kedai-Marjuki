<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $order = Order::with('items')->findOrFail($validated['order_id']);

        // Verifikasi kepemilikan order
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengulas pesanan ini.');
        }

        // Verifikasi status order selesai
        if ($order->order_status !== 'completed' && $order->payment_status !== 'paid') {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah pesanan selesai disajikan.');
        }

        // Verifikasi bahwa produk memang dibeli dalam order ini
        $hasProduct = $order->items->contains(function ($item) use ($validated) {
            return $item->product_id == $validated['product_id'];
        });

        if (!$hasProduct) {
            return back()->with('error', 'Produk ini tidak terdapat dalam rincian pesanan Anda.');
        }

        // Simpan atau perbarui ulasan
        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'product_id' => $validated['product_id'],
            ],
            [
                'rating' => $validated['rating'],
                'comment' => !empty($validated['comment']) ? trim($validated['comment']) : null,
            ]
        );

        return back()->with('success', 'Terima kasih! Ulasan dan rating bintang Anda berhasil disimpan.');
    }
}
