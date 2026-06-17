<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $user  = Auth::user();
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return view('checkout', compact('cart', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $validated = $request->validate([
            'recipient_name'       => 'required|string|max:255',
            'recipient_phone'      => 'required|string|max:20',
            'shipping_address'     => 'required|string',
            'shipping_city'        => 'required|string|max:100',
            'shipping_province'    => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'notes'                => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Validate stock & compute totals
            $subtotal = 0;
            foreach ($cart as $id => $item) {
                $product = Product::lockForUpdate()->findOrFail($id);
                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', "Stok {$product->name} tidak mencukupi (tersisa {$product->stock} {$product->unit}).");
                }
                $subtotal += $product->price * $item['quantity'];
            }

            $shippingCost = 0;
            $total        = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id'              => Auth::id(),
                'subtotal'             => $subtotal,
                'shipping_cost'        => $shippingCost,
                'total_amount'         => $total,
                'payment_method'       => 'midtrans',
                'recipient_name'       => $validated['recipient_name'],
                'recipient_phone'      => $validated['recipient_phone'],
                'shipping_address'     => $validated['shipping_address'],
                'shipping_city'        => $validated['shipping_city'],
                'shipping_province'    => $validated['shipping_province'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'notes'                => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                    'subtotal'   => $product->price * $item['quantity'],
                ]);
                $product->decrement('stock', $item['quantity']);
            }

            // Generate Midtrans Snap Token with a unique midtrans_order_id to prevent sandbox key/order collision
            $midtransOrderId = $order->order_number . '-' . time();
            $snapToken = $this->generateSnapToken($order, $midtransOrderId);
            if ($snapToken) {
                $order->update([
                    'midtrans_snap_token' => $snapToken,
                    'midtrans_order_id'   => $midtransOrderId,
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.detail', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('placeOrder error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Generate or refresh a Midtrans Snap token for an order.
     * Called when order is first created, or when user resumes a pending payment.
     */
    private function generateSnapToken(Order $order, ?string $midtransOrderId = null): ?string
    {
        try {
            \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $params = [
                'transaction_details' => [
                    'order_id'     => $midtransOrderId ?? $order->order_number,
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $order->recipient_name,
                    'phone'      => $order->recipient_phone,
                    'email'      => $order->user->email ?? Auth::user()->email,
                ],
            ];

            return \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Generation Failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Refresh Midtrans snap token for a pending/unpaid order (resume payment).
     */
    public function refreshSnapToken(Order $order)
    {
        // Security: only the order owner can request this
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->payment_status, ['unpaid', 'pending_confirmation'])
            || $order->status === 'cancelled'
        ) {
            return response()->json(['error' => 'Pesanan tidak dapat dibayar.'], 422);
        }

        $midtransOrderId = $order->order_number . '-' . time();
        $snapToken = $this->generateSnapToken($order, $midtransOrderId);

        if (!$snapToken) {
            return response()->json(['error' => 'Gagal mengambil token pembayaran. Coba lagi.'], 500);
        }

        $order->update([
            'midtrans_snap_token' => $snapToken,
            'midtrans_order_id'   => $midtransOrderId,
        ]);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function history()
    {
        $orders = Auth::user()->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.detail', compact('order'));
    }

    public function completeOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'dikirim') {
            return back()->with('error', 'Pesanan belum dikirim.');
        }

        $order->update([
            'status'       => 'selesai',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Terima kasih! Konfirmasi penerimaan pesanan berhasil.');
    }

    /**
     * Check payment status manually from Midtrans API
     */
    public function checkPaymentStatus(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

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

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'status'  => $order->payment_status,
                    'message' => 'Status pembayaran berhasil diperbarui: ' . strtoupper($order->payment_status)
                ]);
            }

            return back()->with('success', 'Status pembayaran berhasil diperbarui: ' . strtoupper($order->payment_status));

        } catch (\Exception $e) {
            Log::error('Check payment status error: ' . $e->getMessage());
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memverifikasi status pembayaran: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal memverifikasi status pembayaran ke Midtrans: ' . $e->getMessage());
        }
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed    = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('midtrans_order_id', $request->order_id)
            ->orWhere('order_number', $request->order_id)
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType       = $request->payment_type;

        if ($transactionStatus === 'capture') {
            if ($paymentType === 'credit_card' && $request->fraud_status === 'challenge') {
                $order->update(['payment_status' => 'pending_confirmation']);
            } else {
                $order->update([
                    'payment_status'           => 'paid',
                    'status'                   => 'confirmed',
                    'paid_at'                  => now(),
                    'midtrans_transaction_id'  => $request->transaction_id ?? null,
                ]);
            }
        } elseif ($transactionStatus === 'settlement') {
            $order->update([
                'payment_status'          => 'paid',
                'status'                  => 'confirmed',
                'paid_at'                 => now(),
                'midtrans_transaction_id' => $request->transaction_id ?? null,
            ]);
        } elseif ($transactionStatus === 'pending') {
            // Midtrans is awaiting payment (e.g. VA waiting to be transferred)
            $order->update(['payment_status' => 'pending_confirmation']);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->update([
                'payment_status' => 'failed',
                'status'         => 'cancelled',
            ]);
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
