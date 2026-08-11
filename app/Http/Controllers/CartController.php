<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCartDetails(auth()->user());
        return view('buyer.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->input('quantity', 1);

        try {
            $this->cartService->addItem(auth()->user(), $request->product_id, $quantity);
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $this->cartService->updateQuantity(auth()->user(), $itemId, $request->quantity);
            return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function remove(int $itemId)
    {
        try {
            $this->cartService->removeItem(auth()->user(), $itemId);
            return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function clear()
    {
        $this->cartService->clearCart(auth()->user());
        return redirect()->route('cart.index')->with('info', 'Keranjang berhasil dikosongkan.');
    }
}
