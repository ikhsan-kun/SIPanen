@extends('layouts.admin')
@section('title','Laporan Penjualan')
@section('page-title','Laporan Penjualan')
@section('page-subtitle','Rekap data penjualan berdasarkan rentang tanggal')

@section('content')
{{-- Filter --}}
<div class="bg-white rounded-2xl border border-slate-100 p-5 mb-6 shadow-sm">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition-colors">
            <i class="fa-solid fa-filter mr-1"></i> Tampilkan
        </button>
        <a href="{{ route('admin.reports.print',['start_date'=>$startDate,'end_date'=>$endDate]) }}" target="_blank"
           class="px-5 py-2.5 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30 inline-flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </a>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center"><i class="fa-solid fa-sack-dollar text-green-600 text-xl"></i></div>
            <div>
                <p class="text-xs text-slate-500">Total Pendapatan</p>
                <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalRevenue,0,',','.') }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center"><i class="fa-solid fa-file-invoice text-blue-600 text-xl"></i></div>
            <div>
                <p class="text-xs text-slate-500">Total Pesanan</p>
                <p class="text-xl font-bold text-slate-800">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center"><i class="fa-solid fa-box text-purple-600 text-xl"></i></div>
            <div>
                <p class="text-xs text-slate-500">Item Terjual</p>
                <p class="text-xl font-bold text-slate-800">{{ $totalItemsSold }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Transactions Table --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Transaksi Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">No. Pesanan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Pelanggan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-3 font-mono text-xs font-semibold text-slate-700">{{ $order->order_number }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $order->user->name }}</td>
                        <td class="px-6 py-3 text-slate-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3 text-right font-bold text-slate-800">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Tidak ada data untuk periode ini.</td></tr>
                    @endforelse
                </tbody>
                @if($orders->isNotEmpty())
                <tfoot class="bg-green-50 border-t-2 border-green-200">
                    <tr>
                        <td colspan="3" class="px-6 py-3.5 text-sm font-bold text-green-800">Total Keseluruhan</td>
                        <td class="px-6 py-3.5 text-right font-bold text-green-800 text-base">Rp {{ number_format($totalRevenue,0,',','.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Best Selling --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Produk Terlaris</h2>
        </div>
        <div class="p-6 space-y-4">
            @forelse($bestSelling as $i => $item)
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
                    {{ $i===0 ? 'bg-yellow-400 text-white' : ($i===1 ? 'bg-slate-300 text-slate-700' : ($i===2 ? 'bg-orange-400 text-white' : 'bg-slate-100 text-slate-600')) }}">
                    {{ $i+1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-800 text-sm truncate">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                    <p class="text-xs text-slate-500">{{ $item->total_qty }} terjual · Rp {{ number_format($item->total_revenue,0,',','.') }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-slate-500 text-center py-6">Belum ada data produk terlaris.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
