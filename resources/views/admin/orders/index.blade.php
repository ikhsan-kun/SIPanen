@extends('layouts.admin')
@section('title','Manajemen Pesanan')
@section('page-title','Manajemen Pesanan')
@section('page-subtitle','Kelola semua pesanan masuk')

@section('content')
<div class="flex flex-wrap gap-3 mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="No. pesanan / pelanggan..."
                   class="pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-56">
        </div>
        <select name="status" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
            <option value="">Semua Status</option>
            @foreach(['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
            <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
            <option value="">Semua Pembayaran</option>
            @foreach(['unpaid'=>'Belum Bayar','pending_confirmation'=>'Menunggu Pembayaran','paid'=>'Lunas','failed'=>'Gagal'] as $v=>$l)
            <option value="{{ $v }}" {{ request('payment_status')===$v?'selected':'' }}>{{ $l }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition-colors">Filter</button>
        @if(request()->hasAny(['search','status','payment_status']))<a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">Reset</a>@endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px] text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Pesanan</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembayaran</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                @php
                $statusColorClass = match($order->status_color) {
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                    'blue' => 'bg-blue-100 text-blue-700',
                    'indigo' => 'bg-indigo-100 text-indigo-700',
                    'purple' => 'bg-purple-100 text-purple-700',
                    'green' => 'bg-green-100 text-green-700',
                    'red' => 'bg-red-100 text-red-700',
                    default => 'bg-slate-100 text-slate-600'
                };
                $pc = match($order->payment_status) {
                    'paid' => 'bg-green-100 text-green-700',
                    'pending_confirmation' => 'bg-orange-100 text-orange-700',
                    'unpaid' => 'bg-red-100 text-red-700',
                    default => 'bg-slate-100 text-slate-600'
                };
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-3.5 font-mono font-semibold text-slate-700 text-xs">{{ $order->order_number }}</td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xs font-bold flex-shrink-0">{{ strtoupper(substr($order->user->name,0,1)) }}</div>
                            <div>
                                <p class="font-medium text-slate-800">{{ Str::limit($order->user->name,18) }}</p>
                                <p class="text-xs text-slate-400">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 font-bold text-slate-800">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColorClass }}">{{ $order->status_label }}</span>
                        @if($order->status === 'dikirim' && $order->tracking_number)
                        <div class="mt-1.5">
                            <a href="{{ route('admin.orders.track-admin', $order->id) }}"
                               class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100 transition-colors"
                               title="Lacak Resi: {{ $order->tracking_number }}">
                                <i class="fa-solid fa-truck text-[9px]"></i> Lacak: {{ Str::limit($order->tracking_number, 10) }}
                            </a>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-3.5"><span class="text-xs font-semibold px-2 py-1 rounded-full {{ $pc }}">{{ $order->payment_status_label }}</span></td>
                    <td class="px-6 py-3.5 text-slate-500 text-xs">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-3.5">
                        <a href="{{ route('admin.orders.show',$order->id) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-eye text-xs"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-16 text-center text-slate-500">
                    <div class="text-4xl mb-3">📋</div>
                    <p>Belum ada pesanan.</p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $orders->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
