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
            // FIX: Wrap search conditions in a where() closure to prevent OR breaking other filters
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', '%' . $search . '%'));
            });
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
            'status'            => 'required|in:pending,confirmed,diproses,dikirim,selesai,cancelled',
            'tracking_number'   => 'nullable|required_if:status,dikirim|string|max:100',
            'shipping_courier'  => 'nullable|required_if:status,dikirim|string|max:50',
        ]);

        $data = ['status' => $request->status];

        // Tracking number & courier: set when shipping
        if ($request->status === 'dikirim') {
            if ($request->filled('tracking_number')) {
                $data['tracking_number'] = $request->tracking_number;
            }
            if ($request->filled('shipping_courier')) {
                $data['shipping_courier'] = $request->shipping_courier;
            }
        }

        // Timestamps: only set once, never overwrite
        if ($request->status === 'dikirim' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($request->status === 'selesai' && !$order->completed_at) {
            $data['completed_at'] = now();
        }

        // Restore stock when order is cancelled (only once, when transitioning TO cancelled)
        if ($request->status === 'cancelled' && $order->status !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
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
                // Restore stock when payment fails (only if not already cancelled)
                if ($order->status !== 'cancelled') {
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }
                }
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
