@extends('layouts.app')
@section('title','Tentang Kami — CV. Ekiindo Tegal')

@section('content')

{{-- Page Header --}}
<div class="border-b border-gray-100 bg-gradient-to-b from-gray-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-green transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
            <span class="text-gray-700 font-medium">Tentang Kami</span>
        </nav>
        <span class="text-primary-green font-bold text-xs uppercase tracking-wider block mb-1">Profil Perusahaan</span>
        <h1 class="text-3xl font-bold text-gray-900">CV. Ekiindo Tegal</h1>
    </div>
</div>

{{-- Profil --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-gray-600 leading-relaxed mb-4 text-sm">
                    CV. Ekiindo Tegal adalah produsen sekaligus distributor terpercaya alat pemanen kelapa sawit berkualitas tinggi. Berlokasi strategis di Kota Tegal, Jawa Tengah, kami mengedepankan kualitas pengerjaan produk yang presisi.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8 text-sm">
                    Dengan pengalaman lebih dari satu dekade, kami berkomitmen menyuplai kebutuhan alat-alat perkebunan sawit baik untuk petani mandiri maupun perusahaan berskala besar di Sumatera, Kalimantan, hingga wilayah Papua.
                </p>

                <div class="grid grid-cols-3 gap-4">
                    @foreach([
                        ['val'=>'10+',  'label'=>'Tahun Pengalaman'],
                        ['val'=>'500+', 'label'=>'Pelanggan Puas'],
                        ['val'=>'3',    'label'=>'Lini Produk Utama'],
                    ] as $s)
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-5 text-center transition">
                        <p class="text-3xl font-bold text-primary-green">{{ $s['val'] }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-1">{{ $s['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Visi box --}}
            <div class="relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary-green to-accent-green rounded-xl blur opacity-10"></div>
                <div class="relative bg-primary-dark rounded-xl p-8 sm:p-10 text-white shadow-md">
                    <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-eye text-green-300"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Visi Perusahaan</h3>
                    <p class="text-gray-300 leading-relaxed text-xs">
                        Menjadi mitra utama terpercaya bagi para petani dan industri kelapa sawit di seluruh penjuru Nusantara dengan senantiasa menghadirkan produk inovatif yang mempermudah proses panen serta mengoptimalkan hasil panen secara berkelanjutan.
                    </p>
                    <div class="mt-6 pt-5 border-t border-white/10 flex flex-wrap gap-4 text-[10px] text-gray-300">
                        <span class="flex items-center space-x-1.5"><i class="fa-solid fa-circle-check text-accent-green"></i> <span>Kualitas Baja Premium</span></span>
                        <span class="flex items-center space-x-1.5"><i class="fa-solid fa-circle-check text-accent-green"></i> <span>Produksi Presisi</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Lini Produk --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-primary-green font-bold text-xs uppercase tracking-wider block mb-1">Unggulan Produksi</span>
            <h2 class="text-2xl font-bold text-gray-900">Lini Produk Kami</h2>
            <p class="text-gray-500 mt-1 max-w-md mx-auto text-xs">Dirancang dan ditempa secara presisi untuk menjamin efisiensi tinggi saat proses panen sawit.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['icon'=>'fa-scissors',               'name'=>'Egrek Sawit',       'desc'=>'Pisau panen melengkung tajam berbahan baja karbon impor premium. Bentuk melengkung yang ergonomis memberikan daya potong maksimal pada pelepah kelapa sawit.'],
                ['icon'=>'fa-hammer',                  'name'=>'Dodos Sawit',       'desc'=>'Pahat panen tajam yang dirancang khusus untuk memotong pelepah sawit pada pohon rendah hingga sedang, menjaga ketajaman lebih lama.'],
                ['icon'=>'fa-arrows-left-right-to-line','name'=>'Gagang Teleskopik','desc'=>'Gagang pipa aluminium alloy tebal yang tangguh namun ringan, memudahkan penyesuaian ketinggian jangkauan pohon kelapa sawit.'],
            ] as $p)
            <div class="bg-white rounded-lg p-8 border border-gray-200 hover:border-primary-green transition card-shadow">
                <div class="w-12 h-12 bg-light-green rounded-lg flex items-center justify-center text-primary-green text-xl mb-6">
                    <i class="fa-solid {{ $p['icon'] }}"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $p['name'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $p['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Siap Mulai Berbelanja?</h2>
        <p class="text-gray-500 mb-6 text-xs">Jelajahi koleksi lengkap alat panen kelapa sawit kami dan temukan yang paling sesuai kebutuhan perkebunan Anda.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('catalog') }}" class="inline-flex items-center space-x-1.5 bg-primary-green hover:bg-accent-green text-white font-bold px-6 py-2.5 rounded-md transition text-xs">
                <i class="fa-solid fa-store"></i> <span>Lihat Katalog Produk</span>
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center space-x-1.5 border border-primary-green text-primary-green hover:bg-gray-50 font-bold px-6 py-2.5 rounded-md transition text-xs">
                <i class="fa-solid fa-phone"></i> <span>Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>

@endsection
