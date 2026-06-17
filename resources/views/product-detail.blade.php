@extends('layouts.app')
@section('title', $product->name)
@section('meta_description', 'Beli ' . $product->name . ' — ' . Str::limit($product->description, 120) . ' | SiPanen')

@push('styles')
<style>
    .badge-egrek           { background: #D8F3DC; color: #1B4332; }
    .badge-dodos           { background: #dbeafe; color: #1d4ed8; }
    .badge-telescopic_pole { background: #fef3c7; color: #b45309; }
    .qty-btn { transition: all .1s; }
    .qty-btn:active { transform: scale(.95); }
    .related-card { transition: transform .2s ease, box-shadow .2s ease; }
    .related-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,.05); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-green transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
            <a href="{{ route('catalog') }}" class="hover:text-primary-green transition-colors">Katalog</a>
            <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
            <span class="text-gray-700 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-10 mb-16">

            {{-- Product Image --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-shadow p-6 flex items-center justify-center">
                @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full max-h-[450px] object-contain">
                @else
                <div class="aspect-square flex flex-col items-center justify-center text-center py-20">
                    <div class="text-8xl mb-4">🌾</div>
                    <p class="text-gray-400 text-sm">Foto produk belum tersedia</p>
                </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="py-2">
                {{-- Category + stock badges --}}
                <div class="flex items-center space-x-2 mb-4">
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full badge-{{ $product->category }}">
                        {{ $product->category_label }}
                    </span>
                    @if($product->stock > 0)
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700">
                        <i class="fa-solid fa-circle-check text-[9px] mr-1"></i> Tersedia
                    </span>
                    @else
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-700">Stok Habis</span>
                    @endif
                </div>

                <h1 class="text-2xl font-bold text-gray-950 mb-3">{{ $product->name }}</h1>

                {{-- Price --}}
                <div class="flex items-baseline space-x-2 mb-6">
                    <span class="text-3xl font-bold text-primary-green">{{ $product->formatted_price }}</span>
                    <span class="text-sm text-gray-400 font-normal">/ {{ $product->unit }}</span>
                </div>

                {{-- Quick specs --}}
                <div class="grid grid-cols-3 gap-3 mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-center">
                        <p class="text-[9px] text-gray-400 font-bold uppercase mb-1">Stok</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $product->stock }} <span class="font-normal text-xs text-gray-400">{{ $product->unit }}</span></p>
                    </div>
                    @if($product->weight)
                    <div class="text-center border-x border-gray-200">
                        <p class="text-[9px] text-gray-400 font-bold uppercase mb-1">Berat</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $product->weight }}</p>
                    </div>
                    @endif
                    @if($product->material)
                    <div class="text-center {{ $product->weight ? '' : 'border-x border-gray-200' }}">
                        <p class="text-[9px] text-gray-400 font-bold uppercase mb-1">Material</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $product->material }}</p>
                    </div>
                    @endif
                </div>

                {{-- Description --}}
                <p class="text-gray-600 leading-relaxed mb-6 text-sm">{{ $product->description }}</p>

                {{-- Specifications --}}
                @if($product->specifications)
                <div class="bg-light-green rounded-lg p-4 mb-6 border border-green-200/50">
                    <h3 class="font-bold text-primary-dark mb-2 text-sm flex items-center space-x-2">
                        <i class="fa-solid fa-list-check"></i> 
                        <span>Spesifikasi</span>
                    </h3>
                    <div class="text-xs text-primary-green whitespace-pre-line leading-relaxed">{{ $product->specifications }}</div>
                </div>
                @endif

                {{-- Add to cart / Out of stock --}}
                @if($product->isAvailable())
                <div class="space-y-3">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-stretch space-x-3">
                        @csrf
                        {{-- Qty --}}
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-white">
                            <button type="button" onclick="changeQty(-1)"
                                    class="qty-btn px-3 py-2 text-gray-600 font-bold text-base hover:bg-gray-100">−</button>
                            <input type="number" name="quantity" id="qty-input" value="1" min="1"
                                   max="{{ $product->stock }}"
                                   class="w-12 text-center py-2 border-x border-gray-300 text-sm font-bold focus:outline-none">
                            <button type="button" onclick="changeQty(1)"
                                    class="qty-btn px-3 py-2 text-gray-600 font-bold text-base hover:bg-gray-100">+</button>
                        </div>
                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center space-x-2 bg-primary-green hover:bg-accent-green text-white font-bold py-2.5 rounded-md transition text-sm">
                            <i class="fa-solid fa-cart-plus"></i> 
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </form>
                    <a href="{{ route('checkout') }}"
                       class="w-full inline-flex items-center justify-center space-x-2 border border-primary-green text-primary-green hover:bg-gray-50 font-bold py-2.5 rounded-md transition text-sm">
                        <i class="fa-solid fa-bolt"></i> 
                        <span>Beli Sekarang</span>
                    </a>
                </div>
                @else
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md text-xs font-medium flex items-center space-x-2">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>Stok habis. Silakan hubungi kami untuk informasi lebih lanjut.</span>
                </div>
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="mt-3 w-full inline-flex items-center justify-center space-x-2 bg-primary-green hover:bg-accent-green text-white font-bold py-2.5 rounded-md transition text-sm">
                    <i class="fa-brands fa-whatsapp"></i> 
                    <span>Tanya Stok via WhatsApp</span>
                </a>
                @endif

                {{-- Trust badges --}}
                <div class="flex items-center flex-wrap gap-4 mt-6 pt-5 border-t border-gray-200">
                    <span class="flex items-center space-x-1.5 text-xs text-gray-500"><i class="fa-solid fa-shield-halved text-primary-green"></i> <span>Produk Terjamin</span></span>
                    <span class="flex items-center space-x-1.5 text-xs text-gray-500"><i class="fa-solid fa-rotate-left text-primary-green"></i> <span>Garansi Retur</span></span>
                    <span class="flex items-center space-x-1.5 text-xs text-gray-500"><i class="fa-solid fa-truck-fast text-primary-green"></i> <span>Pengiriman Aman</span></span>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Produk Sejenis</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($related->take(4) as $rel)
                <a href="{{ route('product.detail', $rel->slug) }}"
                   class="related-card bg-white rounded-lg border border-gray-200 overflow-hidden flex flex-col card-shadow">
                    <div class="h-36 bg-gray-50 flex items-center justify-center p-3">
                        @if($rel->image)
                        <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}"
                             class="max-h-full max-w-full object-contain">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-3xl">🌾</div>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-1 mt-auto">
                        <h3 class="font-bold text-gray-900 text-xs truncate mb-1">{{ $rel->name }}</h3>
                        <p class="text-primary-green font-bold text-sm">{{ $rel->formatted_price }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty-input');
    let val = parseInt(input.value) + delta;
    val = Math.max(1, Math.min(val, parseInt(input.max)));
    input.value = val;
}
</script>
@endpush
