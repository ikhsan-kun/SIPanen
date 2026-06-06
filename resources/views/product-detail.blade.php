@extends('layouts.app')
@section('title',$product->name)

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('catalog') }}" class="hover:text-green-600 transition-colors">Katalog</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-slate-800 font-medium">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            {{-- Product Image --}}
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm aspect-square flex items-center justify-center">
                @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                <div class="text-center">
                    <div class="text-9xl mb-4">🌾</div>
                    <p class="text-slate-400 text-sm">Foto produk belum tersedia</p>
                </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="py-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full
                        {{ $product->category === 'egrek' ? 'bg-green-100 text-green-700' : ($product->category === 'dodos' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                        {{ $product->category_label }}
                    </span>
                    @if($product->stock > 0)
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700">
                        <i class="fa-solid fa-circle-check text-xs mr-1"></i> Tersedia
                    </span>
                    @else
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-red-50 text-red-700">Stok Habis</span>
                    @endif
                </div>

                <h1 class="text-3xl font-bold text-slate-800 mb-3">{{ $product->name }}</h1>
                <div class="text-3xl font-bold text-green-600 mb-6">{{ $product->formatted_price }} <span class="text-lg font-normal text-slate-400">/ {{ $product->unit }}</span></div>

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-slate-50 rounded-2xl">
                    <div class="text-center">
                        <p class="text-xs text-slate-500 mb-1">Stok</p>
                        <p class="font-bold text-slate-800">{{ $product->stock }} <span class="font-normal text-xs">{{ $product->unit }}</span></p>
                    </div>
                    @if($product->weight)
                    <div class="text-center border-x border-slate-200">
                        <p class="text-xs text-slate-500 mb-1">Berat</p>
                        <p class="font-bold text-slate-800">{{ $product->weight }}</p>
                    </div>
                    @endif
                    @if($product->material)
                    <div class="text-center">
                        <p class="text-xs text-slate-500 mb-1">Material</p>
                        <p class="font-bold text-slate-800 text-sm">{{ $product->material }}</p>
                    </div>
                    @endif
                </div>

                <p class="text-slate-600 leading-relaxed mb-6">{{ $product->description }}</p>

                @if($product->specifications)
                <div class="bg-green-50 rounded-2xl p-4 mb-6">
                    <h3 class="font-bold text-green-800 mb-2 text-sm"><i class="fa-solid fa-list-check mr-2"></i>Spesifikasi</h3>
                    <div class="text-sm text-green-700 whitespace-pre-line">{{ $product->specifications }}</div>
                </div>
                @endif

                @if($product->isAvailable())
                <form action="{{ route('cart.add',$product->id) }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden">
                        <button type="button" onclick="changeQty(-1)" class="px-4 py-3 text-slate-600 hover:bg-slate-100 transition-colors font-bold">−</button>
                        <input type="number" name="quantity" id="qty-input" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center py-3 border-x border-slate-200 text-sm font-semibold focus:outline-none">
                        <button type="button" onclick="changeQty(1)" class="px-4 py-3 text-slate-600 hover:bg-slate-100 transition-colors font-bold">+</button>
                    </div>
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                        <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
                <a href="{{ route('checkout') }}" class="mt-3 w-full inline-flex items-center justify-center gap-2 border-2 border-green-600 text-green-700 font-semibold py-3.5 rounded-xl transition-all duration-200 hover:bg-green-50">
                    <i class="fa-solid fa-bolt"></i> Beli Sekarang
                </a>
                @else
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm font-medium">
                    <i class="fa-solid fa-circle-xmark mr-2"></i> Stok habis. Silakan hubungi kami untuk informasi lebih lanjut.
                </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->isNotEmpty())
        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Produk Sejenis</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($related as $rel)
                <a href="{{ route('product.detail',$rel->slug) }}" class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg transition-all duration-200 hover:-translate-y-1 group">
                    <div class="h-40 bg-slate-100 overflow-hidden">
                        @if($rel->image)
                        <img src="{{ asset('storage/'.$rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-4xl">🌾</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-slate-800 text-sm truncate mb-1">{{ $rel->name }}</h3>
                        <p class="text-green-600 font-bold">{{ $rel->formatted_price }}</p>
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
