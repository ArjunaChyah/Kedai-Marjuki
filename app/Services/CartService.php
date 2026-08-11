<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Exception;

class CartService
{
    /**
     * Get or create a cart for the specified user.
     */
    public function getOrCreateCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Add a product to the user's cart.
     */
    public function addItem(User $user, int $productId, int $quantity = 1): CartItem
    {
        $product = Product::findOrFail($productId);

        if (!$product->isAvailable()) {
            throw new Exception("Produk '{$product->name}' sedang tidak tersedia atau stok habis.");
        }

        if ($quantity > $product->stock) {
            throw new Exception("Stok produk '{$product->name}' tidak mencukupi (Tersedia: {$product->stock}).");
        }

        $cart = $this->getOrCreateCart($user);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                throw new Exception("Jumlah melebihi stok yang tersedia ({$product->stock}).");
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $cartItem;
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(User $user, int $cartItemId, int $quantity): bool
    {
        $cart = $this->getOrCreateCart($user);
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->firstOrFail();

        if ($quantity <= 0) {
            return $cartItem->delete();
        }

        if ($quantity > $cartItem->product->stock) {
            throw new Exception("Jumlah melebihi stok produk yang tersedia ({$cartItem->product->stock}).");
        }

        return $cartItem->update(['quantity' => $quantity]);
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(User $user, int $cartItemId): bool
    {
        $cart = $this->getOrCreateCart($user);
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->firstOrFail();

        return (bool) $cartItem->delete();
    }

    /**
     * Clear all items from the user's cart.
     */
    public function clearCart(User $user): void
    {
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $cart->items()->delete();
        }
    }

    /**
     * Get full cart details including items and relationships.
     */
    public function getCartDetails(User $user): ?Cart
    {
        return Cart::with('items.product.category')
            ->where('user_id', $user->id)
            ->first();
    }
}
