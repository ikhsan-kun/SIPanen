@extends('layouts.app')
@section('title', 'Pesanan Saya — SiPanen')
@section('meta_description', 'Pantau semua riwayat pesanan alat panen kelapa sawit Anda di SiPanen. Cek status pengiriman dan pembayaran secara real-time.')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-700 font-medium">Pesanan Saya</span>
        </nav>

        <h1 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
            <span class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-box-open text-sm"></i>
            </span>
            Pesanan Saya
        </h1>

        @if($orders->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center shadow-sm">
            <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-5 text-4xl">📦</div>
            <h2 class="text-lg font-bold text-slate-700 mb-2">Belum Ada Pesanan</h2>
            <p class="text-slate-500 mb-6 text-sm">Anda belum pernah melakukan pemesanan. Yuk mulai belanja!</p>
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-bold px-6 py-3 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/20">
                <i class="fa-solid fa-store"></i> Mulai Belanja Sekarang
            </a>
        </div>
        @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                {{-- Order Header --}}
                <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-3">
                        <span class="font-mono font-bold text-slate-700 text-sm">{{ $order->order_number }}</span>
                        @php
                        $statusClass = match($order->status_color) {
                            'yellow' => 'bg-yellow-100 text-yellow-700',
                            'blue'   => 'bg-blue-100 text-blue-700',
                            'indigo' => 'bg-indigo-100 text-indigo-700',
                            'purple' => 'bg-purple-100 text-purple-700',
                            'green'  => 'bg-green-100 text-green-700',
                            'red'    => 'bg-red-100 text-red-700',
                            default  => 'bg-slate-100 text-slate-600'
                        };
                        $payClass = match($order->payment_status) {
                            'paid'                 => 'bg-green-100 text-green-700',
                            'pending_confirmation' => 'bg-amber-100 text-amber-700',
                            'failed'               => 'bg-red-100 text-red-700',
                            default                => 'bg-slate-100 text-slate-600'
                        };
                        @endphp
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $statusClass }}">{{ $order->status_label }}</span>
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $payClass }}">{{ $order->payment_status_label }}</span>
                    </div>
                    <span class="text-[10px] text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>

                {{-- Order Body --}}
                <div class="p-5 flex flex-wrap items-center gap-4">
                    {{-- Product thumbnails --}}
                    <div class="flex -space-x-2 flex-shrink-0">
                        @foreach($order->items->take(4) as $item)
                        <div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden border-2 border-white shadow-sm">
                            @if($item->product && $item->product->image)
                            <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover" alt="{{ $item->product->name ?? '' }}">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-xs">🌾</div>
                            @endif
                        </div>
                        @endforeach
                        @if($order->items->count() > 4)
                        <div class="w-11 h-11 rounded-xl bg-slate-200 border-2 border-white flex items-center justify-center text-xs font-bold text-slate-600 shadow-sm">+{{ $order->items->count()-4 }}</div>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-700 truncate">
                            {{ $order->items->first()->product->name ?? 'Produk' }}
                            @if($order->items->count() > 1)
                            <span class="font-normal text-slate-400">+{{ $order->items->count()-1 }} produk lainnya</span>
                            @endif
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $order->items->count() }} produk · {{ $order->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- Total + CTA --}}
                    <div class="flex items-center gap-4 ml-auto">
                        <div class="text-right">
                            <p class="text-[10px] text-slate-400">Total</p>
                            <p class="font-extrabold text-green-600 text-base">{{ $order->formatted_total }}</p>
                        </div>
                        @if($order->status === 'dikirim' && $order->tracking_number)
                        <a href="{{ route('orders.track', $order->id) }}"
                           class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-sm shadow-indigo-100">
                            <i class="fa-solid fa-truck-fast text-[10px]"></i> Lacak Resi
                        </a>
                        @endif
                        <a href="{{ route('orders.detail', $order->id) }}"
                           class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-all hover:-translate-y-0.5">
                            Detail <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick action: Pay now for pending orders --}}
                @if(in_array($order->payment_status, ['unpaid', 'pending_confirmation']) && $order->status !== 'cancelled')
                <div class="px-5 pb-4 pt-0">
                    <a href="{{ route('orders.detail', $order->id) }}"
                       class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-400 text-white font-bold text-xs py-2.5 rounded-xl transition-all">
                        <i class="fa-solid fa-bolt"></i> Selesaikan Pembayaran
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
        @endif

    </div>
</div>
@endsection
