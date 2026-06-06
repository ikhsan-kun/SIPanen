@extends('layouts.app')
@section('title','Katalog Produk')
@section('meta_description','Katalog lengkap alat panen kelapa sawit CV. Ekiindo Tegal — Egrek, Dodos, dan Gagang Teleskopik berkualitas tinggi.')

@push('styles')
<style>
.product-card { transition: transform .2s ease, box-shadow .2s ease; }
.product-card:hover { transform:translateY(-4px); box-shadow:0 16px 32px rgba(0,0,0,.1); }
.category-badge-egrek { background:#dcfce7; color:#15803d; }
.category-badge-dodos { background:#dbeafe; color:#1d4ed8; }
.category-badge-telescopic_pole { background:#fef3c7; color:#b45309; }
</style>
@endpush

@section('content')
<div class="pt-24 pb-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Katalog</span>
            <h1 class="text-3xl lg:text-4xl font-bold text-slate-800 mt-1 mb-3">Semua Produk</h1>
            <p class="text-slate-500">Temukan alat panen kelapa sawit pilihan terbaik dari CV. Ekiindo Tegal</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('catalog') }}" class="bg-white rounded-2xl border border-slate-100 p-5 mb-8 flex flex-wrap gap-3 items-end shadow-sm">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cari Produk</label>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>
        <div class="min-w-40">
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kategori</label>
            <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories as $val => $label)
                <option value="{{ $val }}" {{ request('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-40">
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Urutkan</label>
            <select name="sort" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                <option value="">Default</option>
                <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Harga Terendah</option>
                <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Harga Tertinggi</option>
                <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>Terbaru</option>
            </select>
        </div>
        <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold rounded-xl transition-colors">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>
        @if(request()->hasAny(['search','category','sort']))
        <a href="{{ route('catalog') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">Reset</a>
        @endif
    </form>

    {{-- Results Info --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Menampilkan <span class="font-semibold text-slate-800">{{ $products->total() }}</span> produk</p>
    </div>

    {{-- Products Grid --}}
    @if($products->isEmpty())
    <div class="text-center py-24">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-bold text-slate-700 mb-2">Produk tidak ditemukan</h3>
        <p class="text-slate-500 mb-6">Coba ubah filter pencarian Anda</p>
        <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-green-500 transition-colors">Reset Filter</a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach($products as $product)
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden product-card group">
            <div class="h-52 bg-gradient-to-br from-slate-100 to-slate-200 relative overflow-hidden">
                @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center text-6xl">🌾</div>
                @endif
                <div class="absolute top-3 left-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full category-badge-{{ $product->category }}">{{ $product->category_label }}</span>
                </div>
                @if($product->stock === 0)
                <div class="absolute top-3 right-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-700">Habis</span>
                </div>
                @elseif($product->stock <= 5)
                <div class="absolute top-3 right-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-100 text-orange-700">Sisa {{ $product->stock }}</span>
                </div>
                @endif
            </div>
            <div class="p-5">
                <h2 class="font-bold text-slate-800 mb-1 truncate">{{ $product->name }}</h2>
                <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $product->description }}</p>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-lg font-bold text-green-600">{{ $product->formatted_price }}</p>
                        <p class="text-xs text-slate-400">per {{ $product->unit }}</p>
                    </div>
                    <div class="flex gap-2">
                        @if($product->isAvailable())
                        <form action="{{ route('cart.add',$product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-green-100 text-slate-600 hover:text-green-700 transition-all" title="Tambah ke keranjang">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('product.detail',$product->slug) }}" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all hover:-translate-y-0.5">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $products->withQueryString()->links() }}
    @endif
</div>
@endsection
