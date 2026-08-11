<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cart = $this->cartService->getCartDetails(auth()->user());

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu masih kosong. Silakan pilih produk terlebih dahulu.');
        }

        $user = auth()->user();

        return view('buyer.checkout', compact('cart', 'user'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:qris,cash',
        ], [
            'name.required' => 'Nama penerima wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'address.required' => 'Alamat pengiriman/pengambilan wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran harus QRIS atau Tunai.',
        ]);

        try {
            $order = $this->orderService->createOrder(
                auth()->user(),
                [
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'notes' => $validated['notes'] ?? null,
                ],
                $validated['payment_method']
            );

            return redirect()->route('orders.payment', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Nomor Pesanan: ' . $order->order_number);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
