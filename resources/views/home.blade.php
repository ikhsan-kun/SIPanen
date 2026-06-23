@extends('layouts.app')
@section('title', 'Beranda')
@section('meta_description', 'SiPanen — Solusi alat panen kelapa sawit terbaik dari CV. Ekiindo Tegal. Egrek, Dodos, dan Gagang Teleskopik berkualitas premium.')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, rgba(0,40,20,.65) 0%, rgba(0,20,10,.45) 100%),
                    url('/images/hero-sipanen.png');
        background-size: cover;
        background-position: center;
        min-height: 580px;
    }
    .stat-number {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .feature-icon-wrap {
        transition: transform .25s, box-shadow .25s;
    }
    .feature-icon-wrap:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(22,163,74,.15);
    }
    .product-card-home {
        transition: transform .2s, box-shadow .2s;
    }
    .product-card-home:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 32px rgba(0,0,0,.08);
    }
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="hero-section relative flex items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20">
        <div class="max-w-2xl text-white">
            <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-bold text-green-200 px-3 py-1.5 rounded-full mb-6 tracking-wide">
                <i class="fa-solid fa-star text-accent-green text-[10px]"></i>
                PRODUK UNGGULAN CV. EKIINDO TEGAL
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-5">
                Solusi Alat Panen<br/>
                <span class="text-accent-green">Kelapa Sawit</span> Terbaik
            </h1>
            <p class="text-sm text-gray-200 leading-relaxed max-w-lg mb-8">
                Kami menyediakan egrek, dodos, dan gagang teleskopik berkualitas tinggi dengan standar pabrikasi modern untuk menjamin keselamatan kerja dan melipatgandakan produktivitas panen kelapa sawit Anda.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('catalog') }}"
                   class="inline-flex items-center gap-2 bg-primary-green hover:bg-accent-green px-7 py-3.5 rounded-xl font-bold transition-all hover:shadow-lg hover:shadow-green-500/30 hover:-translate-y-0.5 text-white text-sm">
                    <i class="fa-solid fa-store"></i> Mulai Belanja
                </a>
                <a href="{{ route('about') }}"
                   class="inline-flex items-center gap-2 border-2 border-white/50 hover:border-white hover:bg-white/10 px-7 py-3.5 rounded-xl font-bold transition-all text-white text-sm backdrop-blur-sm">
                    Tentang Perusahaan <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Decorative gradient bottom --}}
    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white/20 to-transparent pointer-events-none"></div>
</section>

{{-- Stats Bar --}}
<section class="bg-white border-b border-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-4 text-center">
            <div class="py-2">
                <div class="text-3xl lg:text-4xl font-extrabold stat-number">500+</div>
                <div class="text-gray-500 mt-1 text-sm font-medium">Mitra Perkebunan</div>
            </div>
            <div class="border-y md:border-y-0 md:border-x border-gray-100 py-4 md:py-2">
                <div class="text-3xl lg:text-4xl font-extrabold stat-number">10+</div>
                <div class="text-gray-500 mt-1 text-sm font-medium">Tahun Pengalaman</div>
            </div>
            <div class="py-2">
                <div class="text-3xl lg:text-4xl font-extrabold stat-number">{{ $totalProducts ?? 9 }}</div>
                <div class="text-gray-500 mt-1 text-sm font-medium">Varian Produk</div>
            </div>
        </div>
    </div>
</section>

{{-- Kategori Produk --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-primary-green font-bold text-xs uppercase tracking-widest block mb-2">Lini Produk</span>
            <h2 class="text-3xl font-extrabold text-gray-900">Kategori Produk Kami</h2>
            <p class="text-gray-500 mt-2 text-sm max-w-md mx-auto">Dirancang presisi untuk memaksimalkan efisiensi panen kelapa sawit Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="feature-icon-wrap bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-start">
                <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-scissors text-primary-green text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Egrek Sawit</h3>
                <p class="text-gray-500 text-sm mb-5 leading-relaxed flex-1">Pisau panen melengkung tajam berbahan baja karbon premium dengan desain ergonomis untuk daya potong maksimal.</p>
                <a class="inline-flex items-center gap-1.5 text-primary-green font-bold text-sm hover:gap-3 transition-all"
                   href="{{ route('catalog', ['category' => 'egrek']) }}">
                    Lihat Koleksi <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="feature-icon-wrap bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-start">
                <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-hammer text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Dodos Sawit</h3>
                <p class="text-gray-500 text-sm mb-5 leading-relaxed flex-1">Pahat panen tajam dirancang khusus untuk pohon sawit rendah–sedang, menjaga ketajaman lebih lama.</p>
                <a class="inline-flex items-center gap-1.5 text-primary-green font-bold text-sm hover:gap-3 transition-all"
                   href="{{ route('catalog', ['category' => 'dodos']) }}">
                    Lihat Koleksi <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="feature-icon-wrap bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-start">
                <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-arrows-left-right-to-line text-amber-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Gagang Teleskopik</h3>
                <p class="text-gray-500 text-sm mb-5 leading-relaxed flex-1">Pipa aluminium alloy kuat dan ringan yang dapat disesuaikan ketinggiannya hingga pohon sawit tinggi sekalipun.</p>
                <a class="inline-flex items-center gap-1.5 text-primary-green font-bold text-sm hover:gap-3 transition-all"
                   href="{{ route('catalog', ['category' => 'telescopic_pole']) }}">
                    Lihat Koleksi <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Rekomendasi Produk --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-primary-green font-bold text-xs uppercase tracking-widest block mb-2">Terpopuler</span>
                <h2 class="text-3xl font-extrabold text-gray-900">Rekomendasi Produk</h2>
            </div>
            <a href="{{ route('catalog') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-bold text-primary-green hover:text-accent-green transition-colors">
                Lihat Semua <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">

            @forelse($featuredProducts as $product)
            <div class="product-card-home bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                <a href="{{ route('product.detail', $product->slug) }}" class="block">
                    <div class="aspect-square bg-gray-50 overflow-hidden flex items-center justify-center p-3">
                        @if($product->image)
                        <img alt="{{ $product->name }}" class="w-full h-full object-contain transition-transform duration-300 hover:scale-105" src="{{ $product->image_url }}"/>
                        @else
                        <div class="text-5xl">🌾</div>
                        @endif
                    </div>
                </a>
                <div class="p-4 flex flex-col flex-1">
                    <a href="{{ route('product.detail', $product->slug) }}">
                        <h4 class="font-bold text-sm mb-1 line-clamp-2 text-gray-900 hover:text-primary-green transition-colors" title="{{ $product->name }}">{{ $product->name }}</h4>
                    </a>
                    <p class="text-primary-green font-bold text-sm mb-3 mt-auto">{{ $product->formatted_price }}</p>

                    @if($product->isAvailable())
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-primary-green hover:bg-accent-green text-white py-2 rounded-xl text-xs font-bold transition-all hover:shadow-md hover:shadow-green-500/20 hover:-translate-y-0.5">
                            + Keranjang
                        </button>
                    </form>
                    @else
                    <button disabled class="w-full bg-gray-100 text-gray-400 py-2 rounded-xl text-xs font-bold cursor-not-allowed">Stok Habis</button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-5 text-center text-gray-500 py-16">
                <div class="text-5xl mb-3">🌾</div>
                <p class="font-semibold">Belum ada produk tersedia.</p>
            </div>
            @endforelse

        </div>
        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 border border-primary-green text-primary-green font-bold px-6 py-2.5 rounded-xl hover:bg-green-50 transition-all text-sm">
                Lihat Semua Produk <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

{{-- Mengapa Memilih SiPanen --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="text-primary-green font-bold text-xs uppercase tracking-widest block mb-2">Keunggulan Kami</span>
            <h2 class="text-3xl font-extrabold text-gray-900">Mengapa Memilih SiPanen?</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            @foreach([
                ['icon' => 'fa-shield-halved', 'title' => 'Kualitas Terjamin', 'desc' => 'Baja premium bersertifikat SNI untuk ketahanan maksimal'],
                ['icon' => 'fa-truck-fast',    'title' => 'Pengiriman Handal', 'desc' => 'Pengiriman ke seluruh Indonesia dengan kemasan aman'],
                ['icon' => 'fa-bolt',          'title' => 'Pembayaran Instan', 'desc' => 'QRIS, GoPay, VA Bank, dan banyak metode lainnya'],
                ['icon' => 'fa-rotate-left',   'title' => 'Garansi Retur',    'desc' => 'Garansi pengembalian jika produk tidak sesuai'],
            ] as $f)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:border-green-100 transition-all">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid {{ $f['icon'] }} text-primary-green text-lg"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $f['title'] }}</h4>
                <p class="text-gray-500 text-xs leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-primary-green font-bold text-xs uppercase tracking-widest block mb-2">Ulasan Pelanggan</span>
            <h2 class="text-3xl font-extrabold text-gray-900">Apa Kata Mereka?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['name' => 'Bapak Hendra', 'role' => 'Pekebun Sawit, Riau', 'text' => '"Egrek SiPanen benar-benar tajam dan tahan lama. Sudah 2 musim panen, kualitasnya masih prima. Pengiriman juga cepat sampai ke kebun kami."', 'rating' => 5],
                ['name' => 'Pak Amos Sitorus', 'role' => 'Mandor Perkebunan, Kalimantan Tengah', 'text' => '"Gagang teleskopik dari SiPanen sangat membantu panen di pohon tinggi. Materialnya ringan tapi kokoh. Harga pun bersaing. Sangat direkomendasikan!"', 'rating' => 5],
                ['name' => 'CV Maju Bersama', 'role' => 'Perusahaan Perkebunan, Sumatera Utara', 'text' => '"Kami sudah memesan dalam jumlah besar beberapa kali. Produknya konsisten, pelayanan responsif, dan proses pembayaran via Midtrans sangat mudah."', 'rating' => 5],
            ] as $t)
            <div class="bg-gray-50 rounded-2xl p-7 border border-gray-100 hover:border-green-100 hover:shadow-md transition-all">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < $t['rating']; $i++)
                    <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                    @endfor
                </div>
                <p class="text-gray-700 text-sm leading-relaxed mb-6 italic">{{ $t['text'] }}</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-green flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($t['name'], 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ $t['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $t['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Banner --}}
<section class="py-16 bg-primary-dark">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-2xl lg:text-3xl font-extrabold text-white mb-3">Siap Meningkatkan Produktivitas Panen?</h2>
        <p class="text-gray-400 text-sm mb-8 leading-relaxed">Jelajahi koleksi lengkap alat panen kelapa sawit kami dan temukan yang paling sesuai kebutuhan perkebunan Anda.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('catalog') }}"
               class="inline-flex items-center gap-2 bg-primary-green hover:bg-accent-green text-white font-bold px-7 py-3.5 rounded-xl transition-all hover:shadow-lg hover:shadow-green-500/30 hover:-translate-y-0.5 text-sm">
                <i class="fa-solid fa-store"></i> Belanja Sekarang
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 border border-white/30 hover:border-white text-white font-bold px-7 py-3.5 rounded-xl transition-all hover:bg-white/10 text-sm">
                <i class="fa-brands fa-whatsapp"></i> Konsultasi Gratis
            </a>
        </div>
    </div>
</section>

@endsection
