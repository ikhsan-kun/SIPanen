@extends('layouts.app')
@section('title','Detail Pesanan #'.$order->order_number)

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('orders.history') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 mb-2 transition-colors">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Pesanan
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Detail Pesanan</h1>
                <p class="text-sm font-mono text-slate-500 mt-1">{{ $order->order_number }}</p>
            </div>
            @php
            $statusColor = match($order->status) {
                'pending'=>'bg-yellow-100 text-yellow-800',
                'confirmed'=>'bg-blue-100 text-blue-800',
                'diproses'=>'bg-indigo-100 text-indigo-800',
                'dikirim'=>'bg-purple-100 text-purple-800',
                'selesai'=>'bg-green-100 text-green-800',
                'cancelled'=>'bg-red-100 text-red-800',
                default=>'bg-slate-100 text-slate-700'
            };
            @endphp
            <span class="text-sm font-bold px-4 py-2 rounded-xl {{ $statusColor }}">{{ $order->status_label }}</span>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                {{-- Items --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h2 class="font-bold text-slate-800 mb-4">Item Pesanan</h2>
                    <div class="divide-y divide-slate-50">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 py-3">
                            <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-xl">🌾</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-slate-800 text-sm">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item->quantity }} × Rp {{ number_format($item->price,0,',','.') }}</p>
                            </div>
                            <p class="font-bold text-slate-800 text-sm">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-slate-100 pt-4 mt-2 space-y-2">
                        <div class="flex justify-between text-sm text-slate-600"><span>Subtotal</span><span class="font-semibold">Rp {{ number_format($order->subtotal,0,',','.') }}</span></div>
                        <div class="flex justify-between text-sm text-slate-600"><span>Ongkos Kirim</span><span class="font-semibold">{{ $order->shipping_cost > 0 ? 'Rp '.number_format($order->shipping_cost,0,',','.') : 'Gratis' }}</span></div>
                        <div class="flex justify-between font-bold text-slate-800 pt-2 border-t border-slate-100"><span>Total</span><span class="text-green-600 text-base">Rp {{ number_format($order->total_amount,0,',','.') }}</span></div>
                    </div>
                </div>

                {{-- Payment Status --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h2 class="font-bold text-slate-800 mb-4">Status Pembayaran</h2>
                    @php
                    $payColor = match($order->payment_status) {
                        'paid'=>'border-green-200 bg-green-50',
                        'pending_confirmation'=>'border-orange-200 bg-orange-50',
                        default=>'border-slate-200 bg-slate-50'
                    };
                    @endphp
                    <div class="border rounded-xl p-4 {{ $payColor }}">
                        <p class="font-semibold text-sm mb-1">{{ $order->payment_status_label }}</p>
                        <p class="text-xs text-slate-500">Metode: {{ $order->payment_method === 'midtrans' ? 'Midtrans' : 'Transfer Bank Manual' }}</p>
                        @if($order->paid_at)<p class="text-xs text-slate-500 mt-1">Dibayar: {{ $order->paid_at->format('d M Y, H:i') }}</p>@endif
                    </div>

                    @if($order->paymentConfirmation)
                    <div class="mt-4 p-4 bg-slate-50 rounded-xl">
                        <p class="text-sm font-semibold text-slate-700 mb-2">Bukti Transfer</p>
                        <div class="grid sm:grid-cols-2 gap-3 text-xs text-slate-600 mb-3">
                            <div><span class="text-slate-400">Bank:</span> {{ $order->paymentConfirmation->bank_name }}</div>
                            <div><span class="text-slate-400">Atas Nama:</span> {{ $order->paymentConfirmation->account_name }}</div>
                            <div><span class="text-slate-400">No. Rekening:</span> {{ $order->paymentConfirmation->account_number }}</div>
                            <div><span class="text-slate-400">Jumlah:</span> Rp {{ number_format($order->paymentConfirmation->amount_paid,0,',','.') }}</div>
                            <div><span class="text-slate-400">Tanggal:</span> {{ $order->paymentConfirmation->transfer_date->format('d M Y') }}</div>
                            <div><span class="text-slate-400">Status:</span>
                                <span class="{{ $order->paymentConfirmation->status === 'approved' ? 'text-green-600' : ($order->paymentConfirmation->status === 'rejected' ? 'text-red-600' : 'text-orange-600') }} font-semibold">
                                    {{ ucfirst($order->paymentConfirmation->status) }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$order->paymentConfirmation->transfer_proof) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-semibold text-green-600 hover:text-green-700">
                            <i class="fa-solid fa-image"></i> Lihat Bukti Transfer
                        </a>
                    </div>
                    @elseif(in_array($order->payment_status,['unpaid']) && $order->status !== 'cancelled')
                    <div class="mt-4">
                        @if($order->payment_method === 'transfer')
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-3 text-sm text-amber-800">
                            <p class="font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Segera Lakukan Pembayaran</p>
                            <p class="text-xs">Transfer ke rekening BCA: <strong>1234567890</strong> a.n. CV. Ekiindo Tegal</p>
                            <p class="text-xs mt-1">Jumlah: <strong>Rp {{ number_format($order->total_amount,0,',','.') }}</strong></p>
                        </div>
                        @endif
                        <a href="{{ route('orders.confirm-payment',$order->id) }}" class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all hover:-translate-y-0.5">
                            <i class="fa-solid fa-upload"></i> Upload Bukti Transfer
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h2 class="font-bold text-slate-800 mb-4 text-sm">Informasi Pengiriman</h2>
                    <div class="space-y-2 text-sm">
                        <div><p class="text-xs text-slate-400 mb-0.5">Penerima</p><p class="font-semibold text-slate-800">{{ $order->recipient_name }}</p></div>
                        <div><p class="text-xs text-slate-400 mb-0.5">Telepon</p><p class="font-semibold text-slate-800">{{ $order->recipient_phone }}</p></div>
                        <div><p class="text-xs text-slate-400 mb-0.5">Alamat</p><p class="font-semibold text-slate-800">{{ $order->shipping_address }}</p><p class="text-slate-600">{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p></div>
                        @if($order->shipped_at)<div><p class="text-xs text-slate-400 mb-0.5">Tanggal Kirim</p><p class="font-semibold text-slate-800">{{ $order->shipped_at->format('d M Y') }}</p></div>@endif
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h2 class="font-bold text-slate-800 mb-4 text-sm">Info Pesanan</h2>
                    <div class="space-y-2 text-sm">
                        <div><p class="text-xs text-slate-400 mb-0.5">Tanggal Pesan</p><p class="font-semibold text-slate-800">{{ $order->created_at->format('d M Y, H:i') }}</p></div>
                        @if($order->notes)<div><p class="text-xs text-slate-400 mb-0.5">Catatan</p><p class="text-slate-600">{{ $order->notes }}</p></div>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
