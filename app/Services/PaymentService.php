<?php

namespace App\Services;

use App\Models\Order;
use App\Models\QrisSetting;
use Exception;

class PaymentService
{
    /**
     * Get currently active QRIS configuration.
     */
    public function getActiveQris(): ?QrisSetting
    {
        return QrisSetting::active()->first();
    }

    /**
     * Buyer submits confirmation that they scanned & paid QRIS.
     */
    public function submitQrisPayment(Order $order): void
    {
        if ($order->payment_method !== 'qris') {
            throw new Exception("Pesanan ini tidak menggunakan metode pembayaran QRIS.");
        }

        if ($order->payment_status === 'paid') {
            throw new Exception("Pembayaran untuk pesanan ini sudah dikonfirmasi lunas.");
        }

        $order->update([
            'payment_status' => 'waiting_confirmation',
        ]);
    }

    /**
     * Admin confirms payment as PAID (for QRIS or Cash).
     */
    public function confirmPayment(Order $order): void
    {
        if ($order->payment_status === 'paid') {
            throw new Exception("Pembayaran sudah dikonfirmasi sebelumnya.");
        }

        $order->update([
            'payment_status' => 'paid',
            // Automatically complete order upon payment confirmation for walk-in kedai
            'order_status' => 'completed',
        ]);
    }

    /**
     * Admin rejects QRIS payment confirmation.
     */
    public function rejectPayment(Order $order): void
    {
        $order->update([
            'payment_status' => 'rejected',
        ]);
    }

    /**
     * Admin confirms Cash payment upon receiving payment directly.
     */
    public function confirmCashPayment(Order $order): void
    {
        if ($order->payment_method !== 'cash') {
            throw new Exception("Pesanan ini bukan pesanan pembayaran tunai.");
        }

        $this->confirmPayment($order);
    }
}
