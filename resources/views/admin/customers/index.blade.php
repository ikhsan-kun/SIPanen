@extends('layouts.admin')
@section('title','Manajemen Pelanggan')
@section('page-title','Manajemen Pelanggan')
@section('page-subtitle','Data pelanggan yang terdaftar di sistem')

@section('content')
<div class="mb-6">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-wrap gap-3">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau telepon..."
                   class="pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
        </div>
        <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition-colors">Cari</button>
        @if(request('search'))<a href="{{ route('admin.customers.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">Reset</a>@endif
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[700px] text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Telepon</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pesanan</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Bergabung</th>
                    <th class="px-6 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($customers as $customer)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($customer->name,0,1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $customer->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $customer->phone ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-slate-800">{{ $customer->orders_count }}</span>
                        <span class="text-slate-400 text-xs"> pesanan</span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $customer->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.customers.show',$customer->id) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-eye text-xs"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-16 text-center text-slate-500">
                    <div class="text-4xl mb-3">👤</div>
                    <p>Belum ada pelanggan terdaftar.</p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $customers->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
