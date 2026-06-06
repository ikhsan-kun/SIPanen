@extends('layouts.app')
@section('title','Pesanan Saya')

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-slate-800 mb-8"><i class="fa-solid fa-box text-green-600 mr-2"></i> Pesanan Saya</h1>

        @if($orders->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-100 p-16 text-center shadow-sm">
            <div class="text-7xl mb-4">📦</div>
            <h2 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Pesanan</h2>
            <p class="text-slate-500 mb-6">Anda belum pernah melakukan pemesanan.</p>
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-store"></i> Mulai Belanja
            </a>
        </div>
        @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">No. Pesanan</p>
                        <p class="font-bold text-slate-800 font-mono">{{ $order->order_number }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @php
                        $statusColor = match($order->status) {
                            'pending'=>'bg-yellow-100 text-yellow-700',
                            'confirmed'=>'bg-blue-100 text-blue-700',
                            'diproses'=>'bg-indigo-100 text-indigo-700',
                            'dikirim'=>'bg-purple-100 text-purple-700',
                            'selesai'=>'bg-green-100 text-green-700',
                            'cancelled'=>'bg-red-100 text-red-700',
                            default=>'bg-slate-100 text-slate-600'
                        };
                        $payColor = match($order->payment_status) {
                            'paid'=>'bg-green-100 text-green-700',
                            'pending_confirmation'=>'bg-orange-100 text-orange-700',
                            'unpaid'=>'bg-red-100 text-red-700',
                            default=>'bg-slate-100 text-slate-600'
                        };
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusColor }}">{{ $order->status_label }}</span>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $payColor }}">{{ $order->payment_status_label }}</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 mb-4">
                    <div class="flex -space-x-2">
                        @foreach($order->items->take(3) as $item)
                        <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden border-2 border-white">
                            @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-sm">🌾</div>
                            @endif
                        </div>
                        @endforeach
                        @if($order->items->count() > 3)
                        <div class="w-10 h-10 rounded-lg bg-slate-200 border-2 border-white flex items-center justify-center text-xs font-bold text-slate-600">+{{ $order->items->count()-3 }}</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">{{ $order->items->count() }} produk</p>
                        <p class="text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-xs text-slate-500">Total</p>
                        <p class="font-bold text-green-600">{{ $order->formatted_total }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                    <a href="{{ route('orders.detail',$order->id) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-4 py-2 rounded-xl transition-colors">
                        <i class="fa-solid fa-eye text-xs"></i> Lihat Detail
                    </a>
                    @if(in_array($order->payment_status,['unpaid','pending_confirmation']) && $order->status !== 'cancelled')
                    <a href="{{ route('orders.confirm-payment',$order->id) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-xl transition-colors">
                        <i class="fa-solid fa-upload text-xs"></i> Upload Bukti Transfer
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
