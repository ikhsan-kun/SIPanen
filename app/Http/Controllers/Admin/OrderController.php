<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'          => 'required|in:pending,confirmed,diproses,dikirim,selesai,cancelled',
            'tracking_number' => 'nullable|required_if:status,dikirim|string|max:100',
        ]);

        $data = ['status' => $request->status];

        if ($request->filled('tracking_number')) {
            $data['tracking_number'] = $request->tracking_number;
        }

        if ($request->status === 'dikirim' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($request->status === 'selesai' && !$order->completed_at) {
            $data['completed_at'] = now();
        }

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Check payment status manually from Midtrans API (Admin)
     */
    public function checkPaymentStatus(Order $order)
    {
        try {
            \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');

            // Fetch status directly from Midtrans API using midtrans_order_id (fallback to order_number)
            $midtransId = $order->midtrans_order_id ?: $order->order_number;
            $status = \Midtrans\Transaction::status($midtransId);

            $transactionStatus = $status->transaction_status ?? null;
            $paymentType       = $status->payment_type ?? null;

            if ($transactionStatus === 'capture') {
                if ($paymentType === 'credit_card' && ($status->fraud_status ?? '') === 'challenge') {
                    $order->update(['payment_status' => 'pending_confirmation']);
                } else {
                    $order->update([
                        'payment_status'           => 'paid',
                        'status'                   => 'confirmed',
                        'paid_at'                  => now(),
                        'midtrans_transaction_id'  => $status->transaction_id ?? null,
                    ]);
                }
            } elseif ($transactionStatus === 'settlement') {
                $order->update([
                    'payment_status'          => 'paid',
                    'status'                  => 'confirmed',
                    'paid_at'                 => now(),
                    'midtrans_transaction_id' => $status->transaction_id ?? null,
                ]);
            } elseif ($transactionStatus === 'pending') {
                $order->update(['payment_status' => 'pending_confirmation']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update([
                    'payment_status' => 'failed',
                    'status'         => 'cancelled',
                ]);
            }

            return back()->with('success', 'Status pembayaran berhasil diperbarui: ' . strtoupper($order->payment_status));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Admin check payment status error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memverifikasi status pembayaran ke Midtrans: ' . $e->getMessage());
        }
    }
}
