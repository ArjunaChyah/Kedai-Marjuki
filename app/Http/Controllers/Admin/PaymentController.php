<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function confirm(Order $order)
    {
        try {
            $this->paymentService->confirmPayment($order);
            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi sebagai LUNAS.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(Order $order)
    {
        try {
            $this->paymentService->rejectPayment($order);
            return redirect()->back()->with('success', 'Pembayaran telah DITOLAK.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmCash(Order $order)
    {
        try {
            $this->paymentService->confirmCashPayment($order);
            return redirect()->back()->with('success', 'Pembayaran Tunai berhasil dikonfirmasi LUNAS.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
