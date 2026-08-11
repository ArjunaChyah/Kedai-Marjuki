<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Create a new order from the user's shopping cart.
     */
    public function createOrder(User $user, array $customerData, string $paymentMethod): Order
    {
        $cart = $this->cartService->getCartDetails($user);

        if (!$cart || $cart->items->isEmpty()) {
            throw new Exception("Keranjang belanja kamu masih kosong.");
        }

        if (!in_array($paymentMethod, ['qris', 'cash'])) {
            throw new Exception("Metode pembayaran tidak valid.");
        }

        return DB::transaction(function () use ($user, $cart, $customerData, $paymentMethod) {
            // Validate stock for all items
            foreach ($cart->items as $item) {
                if (!$item->product || !$item->product->isAvailable() || $item->quantity > $item->product->stock) {
                    throw new Exception("Stok untuk produk '{$item->product->name}' tidak mencukupi.");
                }
            }

            $orderNumber = $this->generateOrderNumber();
            $totalPrice = $cart->total_price;

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'customer_name' => $customerData['name'] ?? $user->name,
                'customer_phone' => $customerData['phone'] ?? $user->phone,
                'customer_address' => $customerData['address'] ?? $user->address,
                'notes' => $customerData['notes'] ?? null,
                'total_price' => $totalPrice,
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Empty cart
            $this->cartService->clearCart($user);

            return $order;
        });
    }

    /**
     * Generate unique order number (e.g., KM-20260807-0001).
     */
    public function generateOrderNumber(): string
    {
        $dateStr = date('Ymd');
        $prefix = 'KM-' . $dateStr . '-';

        $lastOrder = Order::where('order_number', 'LIKE', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $nextNumber;
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Order $order, string $status): Order
    {
        $allowedStatuses = ['pending', 'confirmed', 'processing', 'ready', 'completed', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            throw new Exception("Status pesanan tidak valid.");
        }

        $order->update(['order_status' => $status]);
        return $order;
    }
}
