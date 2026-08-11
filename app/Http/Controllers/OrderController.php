<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->whereIn('order_status', ['pending', 'confirmed', 'processing', 'ready'])
            ->count();
        $completedOrders = Order::where('user_id', $user->id)
            ->where('order_status', 'completed')
            ->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('buyer.dashboard', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'recentOrders'
        ));
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load('items.product');

        return view('buyer.orders.show', compact('order'));
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman pembayaran ini.');
        }

        $qrisSetting = $this->paymentService->getActiveQris();

        return view('buyer.payment', compact('order', 'qrisSetting'));
    }

    public function confirmQrisPayment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->paymentService->submitQrisPayment($order);
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Konfirmasi pembayaran berhasil dikirim. Menunggu verifikasi admin.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
