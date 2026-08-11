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
}
