<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'buyer')->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::whereIn('order_status', ['pending', 'confirmed', 'processing'])->count();
        $completedOrders = Order::where('order_status', 'completed')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }

    public function liveStats()
    {
        $pendingOrders = Order::whereIn('order_status', ['pending', 'confirmed', 'processing'])->count();
        $pendingPayments = Order::where('payment_status', 'pending')->where('payment_method', 'qris')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $totalOrders = Order::count();
        $latestOrder = Order::latest()->first();

        return response()->json([
            'pending_orders' => $pendingOrders,
            'pending_payments' => $pendingPayments,
            'total_revenue' => $totalRevenue,
            'formatted_revenue' => 'Rp' . number_format($totalRevenue, 0, ',', '.'),
            'total_orders' => $totalOrders,
            'latest_order_id' => $latestOrder ? $latestOrder->id : 0,
            'latest_order_number' => $latestOrder ? $latestOrder->order_number : '-',
            'latest_customer_name' => $latestOrder ? $latestOrder->customer_name : '-',
        ]);
    }
}
