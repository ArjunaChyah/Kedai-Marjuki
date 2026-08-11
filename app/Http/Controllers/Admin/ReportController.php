<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'this_month');

        $query = Order::where('payment_status', 'paid');

        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                $periodLabel = 'Hari Ini (' . Carbon::today()->translatedFormat('d F Y') . ')';
                break;
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $periodLabel = 'Minggu Ini';
                break;
            case 'this_month':
            default:
                $query->whereYear('created_at', Carbon::now()->year)
                      ->whereMonth('created_at', Carbon::now()->month);
                $periodLabel = 'Bulan Ini (' . Carbon::now()->translatedFormat('F Y') . ')';
                break;
            case 'all':
                $periodLabel = 'Semua Waktu';
                break;
        }

        $orders = $query->latest()->get();
        $totalRevenue = $orders->sum('total_price');
        $totalOrdersCount = $orders->count();
        $completedOrdersCount = $orders->where('order_status', 'completed')->count();

        // Top selling products in this period
        $topProductsQuery = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('order', function ($q) use ($period) {
                $q->where('payment_status', 'paid');
                if ($period === 'today') {
                    $q->whereDate('created_at', Carbon::today());
                } elseif ($period === 'this_week') {
                    $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($period === 'this_month') {
                    $q->whereYear('created_at', Carbon::now()->year)
                      ->whereMonth('created_at', Carbon::now()->month);
                }
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'period',
            'periodLabel',
            'orders',
            'totalRevenue',
            'totalOrdersCount',
            'completedOrdersCount',
            'topProductsQuery'
        ));
    }
}
