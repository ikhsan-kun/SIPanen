@extends('layouts.app')
@section('title','Katalog Produk')
@section('meta_description','Katalog lengkap alat panen kelapa sawit CV. Ekiindo Tegal — Egrek, Dodos, dan Gagang Teleskopik berkualitas tinggi.')

@push('styles')
<style>
    .prod-card { transition: transform .2s ease, box-shadow .2s ease; }
    .prod-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,.05); }
    .badge-egrek           { background: #D8F3DC; color: #1B4332; }
    .badge-dodos           { background: #dbeafe; color: #1d4ed8; }
    .badge-telescopic_pole { background: #fef3c7; color: #b45309; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="border-b border-gray-100 bg-gray-50/50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-green transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
            <span class="text-gray-700 font-medium">Katalog</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Semua Produk</h1>
        <p class="text-gray-500 text-sm">Temukan alat panen kelapa sawit pilihan terbaik dari CV. Ekiindo Tegal</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('catalog') }}"
          class="bg-white rounded-lg border border-gray-200 p-6 mb-8 flex flex-wrap gap-4 items-end card-shadow">
        
        {{-- Search --}}
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Cari Produk</label>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                       class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green focus:border-primary-green bg-white transition">
            </div>
        </div>

        {{-- Category --}}
        <div class="w-full sm:w-auto min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Kategori</label>
            <select name="category" onchange="this.form.submit()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories as $val => $label)
                <option value="{{ $val }}" {{ request('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Sort --}}
        <div class="w-full sm:w-auto min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-700 uppercase mb-1.5">Urutkan</label>
            <select name="sort" onchange="this.form.submit()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green bg-white">
                <option value="">Default</option>
                <option value="price_asc"  {{ request('sort')==='price_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="newest"     {{ request('sort')==='newest'     ? 'selected' : '' }}>Terbaru</option>
            </select>
        </div>

        <div class="flex items-center space-x-2 w-full sm:w-auto">
            <button type="submit"
                    class="flex-1 sm:flex-initial px-5 py-2 bg-primary-green hover:bg-accent-green text-white text-sm font-semibold rounded-md transition duration-150 flex items-center justify-center space-x-1.5">
                <i class="fa-solid fa-filter text-xs"></i> 
                <span>Filter</span>
            </button>
            @if(request()->hasAny(['search','category','sort']))
            <a href="{{ route('catalog') }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-md transition flex items-center justify-center space-x-1">
                <i class="fa-solid fa-xmark text-xs"></i> 
                <span>Reset</span>
            </a>
            @endif
        </div>
    </form>

    {{-- Results count --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">
            Menampilkan <span class="font-bold text-gray-800">{{ $products->total() }}</span> produk
            @if(request('category')) dalam kategori <span class="font-semibold text-primary-green">{{ $categories[request('category')] ?? '' }}</span>@endif
        </p>
    </div>

    {{-- Grid --}}
    @if($products->isEmpty())
    <div class="text-center py-20 bg-white rounded-lg border border-gray-200">
        <div class="text-5xl mb-4">🔍</div>
        <h3 class="text-lg font-bold text-gray-800 mb-1">Produk tidak ditemukan</h3>
        <p class="text-gray-500 mb-6 text-sm">Coba ubah filter atau kata kunci pencarian Anda</p>
        <a href="{{ route('catalog') }}"
           class="inline-flex items-center bg-primary-green hover:bg-accent-green text-white font-semibold px-6 py-2.5 rounded-md transition text-sm">
            Reset Filter
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach($products as $product)
        <div class="prod-card bg-white rounded-lg border border-gray-100 overflow-hidden flex flex-col card-shadow">
            
            {{-- Image --}}
            <div class="h-52 bg-gray-50 relative overflow-hidden flex items-center justify-center">
                @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="w-full h-full object-contain p-4 transition-transform duration-350">
                @else
                <div class="w-full h-full flex items-center justify-center text-5xl">🌾</div>
                @endif
                {{-- Category badge --}}
                <span class="absolute top-3 left-3 text-[10px] font-bold px-2 py-0.5 rounded-full badge-{{ $product->category }}">
                    {{ $product->category_label }}
                </span>
                {{-- Stock badge --}}
                @if($product->stock === 0)
                <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-100 text-red-700">Habis</span>
                @elseif($product->stock <= 5)
                <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-0.5 rounded-full bg-orange-100 text-orange-700">Sisa {{ $product->stock }}</span>
                @endif
            </div>

            {{-- Body --}}
            <div class="p-5 flex flex-col flex-1">
                <h2 class="font-bold text-gray-900 mb-1 truncate group-hover:text-primary-green transition-colors text-base">{{ $product->name }}</h2>
                <p class="text-xs text-gray-500 mb-4 line-clamp-2 leading-relaxed flex-1">{{ $product->description }}</p>
                <div class="flex items-end justify-between mt-auto">
                    <div>
                        <p class="text-lg font-bold text-primary-green leading-none">{{ $product->formatted_price }}</p>
                        <p class="text-[10px] text-gray-400 font-medium mt-1">per {{ $product->unit }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($product->isAvailable())
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="p-2 border border-gray-200 hover:border-primary-green hover:bg-gray-50 text-gray-600 hover:text-primary-green rounded-md transition"
                                    title="Tambah ke keranjang">
                                <i class="fa-solid fa-cart-plus text-sm"></i>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('product.detail', $product->slug) }}"
                           class="inline-flex items-center bg-primary-green hover:bg-accent-green text-white text-xs font-semibold px-4 py-2.5 rounded-md transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        {{ $products->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
