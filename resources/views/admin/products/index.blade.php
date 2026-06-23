@extends('layouts.admin')
@section('title','Manajemen Produk')
@section('page-title','Manajemen Produk')
@section('page-subtitle','Kelola data produk alat panen kelapa sawit')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                   class="pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-52">
        </div>
        <select name="category" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
            <option value="">Semua Kategori</option>
            @foreach($categories as $v => $l)<option value="{{ $v }}" {{ request('category')===$v?'selected':'' }}>{{ $l }}</option>@endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition-colors">Filter</button>
        @if(request()->hasAny(['search','category']))<a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">Reset</a>@endif
    </form>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
        <i class="fa-solid fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px] text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                @if($product->image)<img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                                @else<div class="w-full h-full flex items-center justify-center text-lg">🌾</div>@endif
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $product->name }}</p>
                                <p class="text-xs text-slate-400">{{ Str::limit($product->description,50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $product->category==='egrek' ? 'bg-green-100 text-green-700' : ($product->category==='dodos' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $product->category_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $product->formatted_price }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold {{ $product->stock === 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-orange-600' : 'text-slate-800') }}">
                            {{ $product->stock }}
                        </span>
                        <span class="text-xs text-slate-400"> {{ $product->unit }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit',$product->id) }}" class="p-2 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" data-confirm="Hapus produk ini? Tindakan ini tidak dapat dibatalkan." data-confirm-btn="Ya, Hapus" data-confirm-color="#ef4444">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-16 text-center text-slate-500">
                    <div class="text-4xl mb-3">📦</div>
                    <p>Belum ada produk. <a href="{{ route('admin.products.create') }}" class="text-green-600 font-semibold">Tambah sekarang</a></p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $products->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
