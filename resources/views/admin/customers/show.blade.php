@extends('layouts.admin')
@section('title','Detail Pelanggan')
@section('page-title','Detail Pelanggan')
@section('page-subtitle',$user->name)

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    {{-- Profile Card --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm text-center">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <h2 class="font-bold text-slate-800 text-lg">{{ $user->name }}</h2>
            <p class="text-slate-500 text-sm">{{ $user->email }}</p>
            <p class="text-slate-400 text-xs mt-1">Bergabung {{ $user->created_at->format('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 mb-4 text-sm">Informasi Kontak</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-3"><i class="fa-solid fa-phone text-green-600 w-4"></i><span class="text-slate-700">{{ $user->phone ?? '-' }}</span></div>
                <div class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-green-600 w-4 mt-0.5"></i><span class="text-slate-700">{{ $user->address ? $user->address.', '.$user->city.', '.$user->province.' '.$user->postal_code : '-' }}</span></div>
                @if($user->company_name)<div class="flex items-center gap-3"><i class="fa-solid fa-building text-green-600 w-4"></i><span class="text-slate-700">{{ $user->company_name }}</span></div>@endif
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 mb-4 text-sm">Statistik</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-xl p-3 text-center"><p class="text-2xl font-bold text-slate-800">{{ $orders->count() }}</p><p class="text-xs text-slate-500">Total Pesanan</p></div>
                <div class="bg-green-50 rounded-xl p-3 text-center"><p class="text-lg font-bold text-green-700">Rp {{ number_format($totalSpent/1000,0,',','.') }}K</p><p class="text-xs text-slate-500">Total Belanja</p></div>
            </div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-bold text-slate-800">Riwayat Pesanan</h2>
            </div>
            @if($orders->isEmpty())
            <div class="py-12 text-center text-slate-500">
                <div class="text-4xl mb-3">📦</div>
                <p>Pelanggan ini belum memiliki pesanan.</p>
            </div>
            @else
            <div class="divide-y divide-slate-50">
                @foreach($orders as $order)
                @php
                $sc = match($order->status) {'pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-blue-100 text-blue-700','diproses'=>'bg-indigo-100 text-indigo-700','dikirim'=>'bg-purple-100 text-purple-700','selesai'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700',default=>'bg-slate-100 text-slate-600'};
                @endphp
                 <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/50 transition-colors">
                    <div>
                        <p class="font-mono font-semibold text-slate-700 text-xs">{{ $order->order_number }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} · {{ $order->items->count() }} produk</p>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc }}">{{ $order->status_label }}</span>
                        <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($order->total_amount,0,',','.') }}</span>
                        <a href="{{ route('admin.orders.show',$order->id) }}" class="text-green-600 hover:text-green-700 text-xs font-semibold">Detail →</a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
