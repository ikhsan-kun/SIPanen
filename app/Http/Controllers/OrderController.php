<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentConfirmation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'payment_method'       => 'required|in:transfer,midtrans',
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

            $shippingCost = 0; // simplified
            $total        = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id'              => Auth::id(),
                'subtotal'             => $subtotal,
                'shipping_cost'        => $shippingCost,
                'total_amount'         => $total,
                'payment_method'       => $validated['payment_method'],
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

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.detail', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
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
        $order = Order::with(['items.product', 'paymentConfirmation'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.detail', compact('order'));
    }

    public function showConfirmPayment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        if ($order->payment_status === 'paid') {
            return back()->with('info', 'Pembayaran sudah dikonfirmasi.');
        }
        return view('orders.confirm-payment', compact('order'));
    }

    public function submitConfirmPayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'bank_name'      => 'required|string|max:100',
            'account_name'   => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'amount_paid'    => 'required|numeric|min:1',
            'transfer_date'  => 'required|date',
            'transfer_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('transfer_proof')->store('payment_proofs', 'public');

        PaymentConfirmation::updateOrCreate(
            ['order_id' => $order->id],
            [
                'bank_name'      => $validated['bank_name'],
                'account_name'   => $validated['account_name'],
                'account_number' => $validated['account_number'],
                'amount_paid'    => $validated['amount_paid'],
                'transfer_date'  => $validated['transfer_date'],
                'transfer_proof' => $path,
                'status'         => 'pending',
            ]
        );

        $order->update(['payment_status' => 'pending_confirmation']);

        return redirect()->route('orders.detail', $order->id)
            ->with('success', 'Konfirmasi pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
