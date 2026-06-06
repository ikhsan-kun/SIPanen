<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $orders = Order::with(['user', 'items.product'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue    = $orders->sum('total_amount');
        $totalOrders     = $orders->count();
        $totalItemsSold  = $orders->sum(fn($o) => $o->items->sum('quantity'));

        // Best selling products
        $bestSelling = OrderItem::with('product')
            ->whereHas('order', fn($q) =>
                $q->where('payment_status', 'paid')
                  ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            )
            ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'orders', 'totalRevenue', 'totalOrders', 'totalItemsSold',
            'bestSelling', 'startDate', 'endDate'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $orders = Order::with(['user', 'items.product'])
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders  = $orders->count();

        return view('admin.reports.print', compact('orders', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
    }
}
