<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders    = Order::count();
        $totalProducts  = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $pendingConfirmations = Order::where('payment_status', 'pending_confirmation')->count();
        $pendingOrders        = Order::where('status', 'pending')->count();
        $lowStockProducts     = Product::where('stock', '<=', 5)->where('is_active', true)->get();

        // Monthly revenue for current year
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $revenueData = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueData[] = $monthlyRevenue[$m] ?? 0;
        }

        // Orders by status
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalCustomers',
            'recentOrders', 'pendingConfirmations', 'pendingOrders',
            'lowStockProducts', 'revenueData', 'ordersByStatus'
        ));
    }
}
