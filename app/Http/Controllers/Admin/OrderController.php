<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'paymentConfirmation']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,diproses,dikirim,selesai,cancelled',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'dikirim' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($request->status === 'selesai' && !$order->completed_at) {
            $data['completed_at'] = now();
        }

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function confirmPayment(Request $request, $confirmationId)
    {
        $request->validate([
            'action'      => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string',
        ]);

        $confirmation = PaymentConfirmation::with('order')->findOrFail($confirmationId);

        if ($request->action === 'approve') {
            $confirmation->update(['status' => 'approved', 'admin_notes' => $request->admin_notes]);
            $confirmation->order->update([
                'payment_status' => 'paid',
                'status'         => 'confirmed',
                'paid_at'        => now(),
            ]);
            $msg = 'Pembayaran berhasil dikonfirmasi.';
        } else {
            $confirmation->update(['status' => 'rejected', 'admin_notes' => $request->admin_notes]);
            $confirmation->order->update(['payment_status' => 'unpaid']);
            $msg = 'Konfirmasi pembayaran ditolak.';
        }

        return back()->with('success', $msg);
    }
}
