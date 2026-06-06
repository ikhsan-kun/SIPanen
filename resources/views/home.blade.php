@extends('layouts.app')
@section('title','Beranda')

@push('styles')
<style>
.hero-bg {
    background: linear-gradient(135deg, #052e16 0%, #14532d 40%, #166534 70%, #15803d 100%);
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}
.hero-bg::before {
    content:'';
    position:absolute;inset:0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.stat-card { background:rgba(255,255,255,0.1); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.15); }
.product-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
.category-badge-egrek { background:#dcfce7; color:#15803d; }
.category-badge-dodos { background:#dbeafe; color:#1d4ed8; }
.category-badge-telescopic_pole { background:#fef3c7; color:#b45309; }
.floating { animation: floating 3s ease-in-out infinite; }
@keyframes floating { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-10px); } }
.wave-divider svg { display:block; }
</style>
@endpush

@section('content')
{{-- HERO --}}
<section class="hero-bg flex items-center">
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 lg:py-40">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/30 text-green-300 text-sm font-medium px-4 py-2 rounded-full mb-6">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                    Produk Bersertifikat & Terpercaya
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    Alat Panen<br>
                    <span class="text-transparent bg-clip-text" style="background:linear-gradient(90deg,#4ade80,#86efac)">Kelapa Sawit</span><br>
                    Berkualitas
                </h1>
                <p class="text-lg text-green-100/80 leading-relaxed mb-8 max-w-lg">
                    CV. Ekiindo Tegal menghadirkan egrek, dodos, dan gagang teleskopik premium untuk meningkatkan produktivitas panen kelapa sawit Anda.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-400 text-white font-semibold px-7 py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-green-900/40 hover:-translate-y-0.5">
                        <i class="fa-solid fa-store"></i> Lihat Katalog
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-7 py-3.5 rounded-xl border border-white/20 transition-all duration-200 hover:-translate-y-0.5">
                        <i class="fa-solid fa-circle-info"></i> Tentang Kami
                    </a>
                </div>
                <div class="flex items-center gap-8 mt-12 pt-8 border-t border-white/10">
                    <div class="stat-card px-5 py-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-white">500+</p>
                        <p class="text-xs text-green-200 mt-0.5">Pelanggan</p>
                    </div>
                    <div class="stat-card px-5 py-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-white">10+</p>
                        <p class="text-xs text-green-200 mt-0.5">Tahun Berpengalaman</p>
                    </div>
                    <div class="stat-card px-5 py-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-white">{{ $totalProducts }}</p>
                        <p class="text-xs text-green-200 mt-0.5">Varian Produk</p>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex items-center justify-center">
                <div class="relative floating">
                    <div class="w-80 h-80 rounded-full" style="background:radial-gradient(circle,rgba(74,222,128,0.3),transparent 70%)"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-8xl mb-4">🌴</div>
                            <p class="text-white/60 text-sm font-medium">Alat Panen Profesional</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wave-divider absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Kategori Produk</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-800 mt-2">Pilihan Alat Panen Terlengkap</h2>
            <p class="text-slate-500 mt-3 max-w-xl mx-auto">Temukan alat panen kelapa sawit sesuai kebutuhan Anda dari koleksi produk kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['cat'=>'egrek','icon'=>'🔪','title'=>'Egrek','desc'=>'Pisau panen berujung melengkung dengan mata tajam dari baja pilihan untuk memotong tandan kelapa sawit dengan efisien.','color'=>'from-green-500 to-emerald-600'],
                ['cat'=>'dodos','icon'=>'⚒️','title'=>'Dodos','desc'=>'Alat panen berupa pahat tajam khusus untuk memungut brondolan sawit yang jatuh ke tanah dengan cepat dan akurat.','color'=>'from-blue-500 to-cyan-600'],
                ['cat'=>'telescopic_pole','icon'=>'📏','title'=>'Gagang Teleskopik','desc'=>'Gagang panjang yang dapat disetel panjang-pendeknya untuk menjangkau tandan buah di pohon yang tinggi.','color'=>'from-amber-500 to-orange-600'],
            ] as $cat)
            <a href="{{ route('catalog',['category'=>$cat['cat']]) }}"
               class="group bg-white rounded-2xl p-8 border border-slate-100 hover:border-transparent product-card hover:shadow-xl">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $cat['color'] }} flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform duration-200">
                    {{ $cat['icon'] }}
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $cat['title'] }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-4">{{ $cat['desc'] }}</p>
                <span class="inline-flex items-center gap-1 text-sm font-semibold text-green-600 group-hover:gap-2 transition-all duration-200">
                    Lihat Produk <i class="fa-solid fa-arrow-right text-xs"></i>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Produk Unggulan</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-800 mt-2">Produk Terpopuler</h2>
            </div>
            <a href="{{ route('catalog') }}" class="hidden sm:inline-flex items-center gap-2 text-green-600 font-semibold text-sm hover:text-green-700 transition-colors">
                Lihat Semua <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if($featuredProducts->isEmpty())
        <div class="text-center py-16">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-slate-500">Belum ada produk tersedia.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredProducts as $product)
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
                    @if($product->stock <= 5 && $product->stock > 0)
                    <div class="absolute top-3 right-3">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-100 text-orange-700">Stok Terbatas</span>
                    </div>
                    @elseif($product->stock === 0)
                    <div class="absolute top-3 right-3">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-700">Habis</span>
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-800 mb-1 truncate">{{ $product->name }}</h3>
                    <p class="text-xs text-slate-500 mb-3 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-green-600">{{ $product->formatted_price }}</p>
                            <p class="text-xs text-slate-400">per {{ $product->unit }}</p>
                        </div>
                        <a href="{{ route('product.detail',$product->slug) }}" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
                            Detail <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-green-500 transition-colors">
                Lihat Semua Produk <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- WHY US --}}
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Keunggulan Kami</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-800 mt-2">Mengapa Memilih SiPanen?</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon'=>'fa-shield-halved','color'=>'bg-green-100 text-green-600','title'=>'Produk Terjamin','desc'=>'Setiap produk melewati quality control ketat sebelum sampai ke tangan Anda.'],
                ['icon'=>'fa-truck-fast','color'=>'bg-blue-100 text-blue-600','title'=>'Pengiriman Cepat','desc'=>'Pesanan diproses dan dikirim dalam 1-2 hari kerja ke seluruh Indonesia.'],
                ['icon'=>'fa-headset','color'=>'bg-purple-100 text-purple-600','title'=>'Layanan 24/7','desc'=>'Tim kami siap membantu Anda kapan saja melalui WhatsApp atau email.'],
                ['icon'=>'fa-rotate-left','color'=>'bg-orange-100 text-orange-600','title'=>'Garansi Produk','desc'=>'Jaminan kualitas dengan garansi pengembalian barang jika ada cacat produksi.'],
            ] as $f)
            <div class="bg-white rounded-2xl p-6 border border-slate-100 text-center hover:shadow-lg transition-shadow duration-200">
                <div class="w-14 h-14 {{ $f['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid {{ $f['icon'] }} text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-800 mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20" style="background:linear-gradient(135deg,#052e16,#166534)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Siap Meningkatkan Produktivitas Panen?</h2>
        <p class="text-green-200 mb-8 max-w-xl mx-auto">Bergabunglah dengan ratusan pelanggan yang telah mempercayakan kebutuhan alat panen mereka kepada CV. Ekiindo Tegal.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-400 text-white font-semibold px-7 py-3.5 rounded-xl transition-all duration-200 shadow-lg hover:-translate-y-0.5">
                <i class="fa-solid fa-store"></i> Belanja Sekarang
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-7 py-3.5 rounded-xl border border-white/20 transition-all duration-200 hover:-translate-y-0.5">
                <i class="fa-brands fa-whatsapp"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
