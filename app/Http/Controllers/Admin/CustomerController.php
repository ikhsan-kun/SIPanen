<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $orders = $user->orders()
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSpent = $user->orders()->where('payment_status', 'paid')->sum('total_amount');

        return view('admin.customers.show', compact('user', 'orders', 'totalSpent'));
    }
}
