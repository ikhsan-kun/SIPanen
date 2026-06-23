@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->order_number)
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', '#' . $order->order_number)

@section('content')
<div class="grid lg:grid-cols-3 gap-6">

    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Items --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-sm">Produk Dipesan</h2>
                <span class="text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full font-semibold">{{ $order->items->count() }} item</span>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                        @if($item->product && $item->product->image)
                        <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover" alt="{{ $item->product->name ?? '' }}">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-xl bg-slate-100">🌾</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $item->quantity }} {{ $item->product->unit ?? 'pcs' }} × Rp {{ number_format($item->price,0,',','.') }}</p>
                    </div>
                    <p class="font-bold text-slate-800 text-sm flex-shrink-0">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 space-y-2">
                <div class="flex justify-between text-sm text-slate-500">
                    <span>Subtotal</span>
                    <span class="font-semibold text-slate-700">Rp {{ number_format($order->subtotal,0,',','.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-slate-500">
                    <span>Ongkos Kirim</span>
                    <span class="font-semibold text-slate-700">{{ $order->shipping_cost > 0 ? 'Rp '.number_format($order->shipping_cost,0,',','.') : 'Gratis' }}</span>
                </div>
                <div class="flex justify-between font-bold text-slate-800 text-base pt-2 border-t border-slate-100">
                    <span>Total Tagihan</span>
                    <span class="text-green-600">Rp {{ number_format($order->total_amount,0,',','.') }}</span>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-bold text-slate-800 mb-5 text-sm">Update Status Pesanan</h2>
            @if(session('success'))
            <div class="mb-4 flex items-center gap-2 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-xl text-sm">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                @csrf @method('PATCH')
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Status Pesanan</label>
                        <select name="status" id="status-select"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            @foreach([
                                'pending'   => '⏳ Menunggu Pembayaran',
                                'confirmed' => '📦 Sedang Dikemas',
                                'diproses'  => '🔧 Sedang Diproses',
                                'dikirim'   => '🚚 Dalam Pengiriman',
                                'selesai'   => '✅ Selesai',
                                'cancelled' => '❌ Dibatalkan',
                            ] as $val => $label)
                            <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="tracking-input-wrapper" class="{{ $order->status === 'dikirim' ? '' : 'hidden' }}">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Nomor Resi Pengiriman <span class="text-red-500">*</span></label>
                        <input type="text" name="tracking_number"
                               value="{{ old('tracking_number', $order->tracking_number) }}"
                               placeholder="Contoh: JNE12345678"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-bold px-6 py-3 rounded-xl transition-all shadow-md shadow-green-500/20 text-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui Status
                    </button>
                </div>
            </form>
        </div>

        {{-- Tracking Info (Lacak Resi) --}}
        @if($order->tracking_number)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-bold text-slate-800 mb-4 text-sm">Pelacakan Pengiriman</h2>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-xl border border-purple-100 bg-purple-50/50">
                <div>
                    <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block mb-0.5">Nomor Resi</span>
                    <span class="font-mono font-bold text-slate-800 text-sm">{{ $order->tracking_number }}</span>
                </div>
                <a href="{{ route('admin.orders.track-admin', $order->id) }}"
                   class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-100">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i> Lacak Resi Pengiriman
                </a>
            </div>
        </div>
        @endif

        {{-- Payment Status (Midtrans) --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-bold text-slate-800 mb-4 text-sm">Status Pembayaran</h2>
            @php
            $payBgClass = match($order->payment_status) {
                'paid'                 => 'border-green-100 bg-green-50/50 text-green-800',
                'pending_confirmation' => 'border-amber-100 bg-amber-50/50 text-amber-800',
                'failed'               => 'border-red-100 bg-red-50/50 text-red-800',
                default                => 'border-slate-100 bg-slate-50 text-slate-700'
            };
            $payIcon = match($order->payment_status) {
                'paid'                 => 'fa-circle-check text-green-500',
                'pending_confirmation' => 'fa-clock text-amber-500',
                'failed'               => 'fa-circle-xmark text-red-500',
                default                => 'fa-clock text-slate-400'
            };
            @endphp
            <div class="border rounded-2xl p-4 {{ $payBgClass }} flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <i class="fa-solid {{ $payIcon }} text-xl flex-shrink-0"></i>
                    <div>
                        <span class="font-bold text-sm block">{{ $order->payment_status_label }}</span>
                        <span class="text-xs opacity-70 block mt-0.5">Metode: Midtrans Online Payment</span>
                        @if($order->paid_at)
                        <span class="text-xs opacity-70 block">Dibayar: {{ $order->paid_at->format('d M Y, H:i') }}</span>
                        @endif
                        @if($order->midtrans_transaction_id)
                        <span class="text-xs font-mono opacity-70 block">TXN ID: {{ $order->midtrans_transaction_id }}</span>
                        @endif
                    </div>
                </div>
                @if(in_array($order->payment_status, ['unpaid', 'pending_confirmation']))
                <form action="{{ route('admin.orders.check-status', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs px-3.5 py-2 rounded-xl transition-all shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                        <i class="fa-solid fa-arrows-rotate text-[10px]"></i> Cek Status
                    </button>
                </form>
                @endif
            </div>
        </div>

    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">

        {{-- Order Status Badge --}}
        @php
        $headerBadge = match($order->status_color) {
            'yellow' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
            'blue'   => 'bg-blue-50 border-blue-200 text-blue-700',
            'indigo' => 'bg-indigo-50 border-indigo-200 text-indigo-700',
            'purple' => 'bg-purple-50 border-purple-200 text-purple-700',
            'green'  => 'bg-green-50 border-green-200 text-green-700',
            'red'    => 'bg-red-50 border-red-200 text-red-700',
            default  => 'bg-slate-50 border-slate-200 text-slate-600'
        };
        @endphp
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Saat Ini</p>
            <span class="inline-flex items-center gap-2 font-bold text-sm px-4 py-2 rounded-xl border {{ $headerBadge }}">
                <span class="w-2 h-2 rounded-full bg-current"></span>
                {{ $order->status_label }}
            </span>
        </div>

        {{-- Customer --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h2 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4">Informasi Pelanggan</h2>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-slate-800 text-sm truncate">{{ $order->user->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $order->user->email }}</p>
                </div>
            </div>
            <a href="{{ route('admin.customers.show', $order->user->id) }}"
               class="text-xs font-bold text-green-600 hover:text-green-700 flex items-center gap-1 transition-colors">
                Lihat Profil <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- Shipping Address --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h2 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4">Alamat Pengiriman</h2>
            <div class="space-y-2.5 text-xs">
                <div>
                    <span class="text-slate-400 block">Penerima</span>
                    <span class="font-bold text-slate-800">{{ $order->recipient_name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">No. Telepon</span>
                    <span class="font-semibold text-slate-700">{{ $order->recipient_phone }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Alamat</span>
                    <span class="font-medium text-slate-700 leading-relaxed block">{{ $order->shipping_address }}</span>
                    <span class="text-slate-500 block mt-0.5">{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</span>
                </div>
                @if($order->notes)
                <div>
                    <span class="text-slate-400 block">Catatan</span>
                    <span class="italic text-slate-600">"{{ $order->notes }}"</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Timeline --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h2 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4">Timeline</h2>
            <div class="relative pl-5 border-l-2 border-slate-100 space-y-5">
                <div class="relative">
                    <div class="absolute -left-[22px] top-1 w-3 h-3 rounded-full bg-green-500 border-2 border-white shadow-sm"></div>
                    <p class="text-xs font-bold text-slate-800">Pesanan Dibuat</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
                @if($order->paid_at)
                <div class="relative">
                    <div class="absolute -left-[22px] top-1 w-3 h-3 rounded-full bg-green-500 border-2 border-white shadow-sm"></div>
                    <p class="text-xs font-bold text-slate-800">Pembayaran Lunas</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $order->paid_at->format('d M Y, H:i') }} WIB</p>
                </div>
                @endif
                @if($order->shipped_at)
                <div class="relative">
                    <div class="absolute -left-[22px] top-1 w-3 h-3 rounded-full bg-purple-500 border-2 border-white shadow-sm"></div>
                    <p class="text-xs font-bold text-slate-800">Dikirim ke Ekspedisi</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $order->shipped_at->format('d M Y, H:i') }} WIB</p>
                    @if($order->tracking_number)
                    <p class="text-[10px] font-mono text-purple-600 mt-0.5">Resi: {{ $order->tracking_number }}</p>
                    @endif
                </div>
                @endif
                @if($order->completed_at)
                <div class="relative">
                    <div class="absolute -left-[22px] top-1 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white shadow-sm"></div>
                    <p class="text-xs font-bold text-slate-800">Pesanan Selesai</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $order->completed_at->format('d M Y, H:i') }} WIB</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect       = document.getElementById('status-select');
    const trackingWrapper    = document.getElementById('tracking-input-wrapper');

    statusSelect.addEventListener('change', function () {
        trackingWrapper.classList.toggle('hidden', this.value !== 'dikirim');
    });
});
</script>
@endpush
@endsection
