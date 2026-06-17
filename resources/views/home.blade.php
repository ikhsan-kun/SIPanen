@extends('layouts.app')
@section('title', 'Beranda')
@section('meta_description', 'SiPanen — Solusi alat panen kelapa sawit terbaik dari CV. Ekiindo Tegal. Egrek, Dodos, dan Gagang Teleskopik berkualitas premium.')

@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuA5tuEVNXVQ3OWgjiU4nPXAtS5qJQ__mzYF67i-cAH3LylYo5-F0udUmerfWw2qjGyRwS9KQUCiNa7asGELIFEeqO7Fss62d9LtDOdkJTP9E4UqJjUj0obM7_zMmKna7bLC_fid9vFEkGDG54wm6fOknQfH2sbAahTKHUZkcu_fXVTqdC1t57Pzr8C_VZI6Nhy1jnZyWKFEUeltUsk0exhUOpxKgWyrPrjKCIc4YXffrmCpa_-_t5p_aOlzOKdAzJq2OJts_UnYPxk');
        background-size: cover;
        background-position: center;
        height: 600px; 
    }
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="hero-gradient relative flex items-center" data-purpose="hero-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-2xl text-white">
            <h1 class="text-5xl font-bold leading-tight mb-6">Solusi Alat Panen<br/>Kelapa Sawit Terbaik</h1>
            <div class="flex space-x-4 mb-8">
                <a href="{{ route('catalog') }}" class="bg-primary-green hover:bg-accent-green px-8 py-3 rounded-lg font-bold transition text-white inline-block text-center">Mulai Belanja</a>
                <a href="{{ route('about') }}" class="border-2 border-white hover:bg-white hover:text-primary-dark px-8 py-3 rounded-lg font-bold transition text-white inline-block text-center">Tentang Perusahaan</a>
            </div>
            <p class="text-sm opacity-90 leading-relaxed max-w-md">
                Kami menyediakan egrek, dodos, dan gagang teleskopik berkualitas tinggi dengan standar pabrikasi modern untuk menjamin keselamatan kerja dan melipatgandakan produktivitas panen kelapa sawit Anda.
            </p>
        </div>
    </div>
    
    {{-- Hero Pagination Dots --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex space-x-2">
        <span class="w-2 h-2 rounded-full bg-white"></span>
        <span class="w-2 h-2 rounded-full bg-white opacity-50"></span>
        <span class="w-2 h-2 rounded-full bg-white opacity-50"></span>
    </div>
</section>

{{-- Stats Bar --}}
<section class="bg-white py-12 border-b border-gray-100" data-purpose="stats-bar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-gray-900">500+</div>
                <div class="text-gray-500 mt-1 text-sm">Mitra Perkebunan</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-gray-900">10+ Tahun</div>
                <div class="text-gray-500 mt-1 text-sm">Berpengalaman</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-gray-900">{{ $totalProducts ?? 9 }}</div>
                <div class="text-gray-500 mt-1 text-sm">Kategori Produk</div>
            </div>
        </div>
    </div>
</section>

{{-- Kategori Produk --}}
<section class="py-20" data-purpose="category-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Kategori Produk</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Category Card 1 -->
            <div class="bg-white p-8 rounded-xl card-shadow border border-gray-50 flex flex-col items-start transition hover:scale-105">
                <div class="bg-light-green p-4 rounded-lg mb-6">
                    <img alt="Egrek Sawit Icon" class="h-8 w-8" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDop9vhR1A4lW8qJP3k4Y3HNjv7hlC6CVtjcMqToxtHPHM9sYQRjkEy-Ut0gSaqpmH_RfKu2nqOL_6OK74F3xMDwP4_I9lAPx6siKiEBZaU9ZD0s9bqJ_Mh8-DzlUI6Tncy7b24fmOyXt1jhIQh8kqGZvAD_l2EiFQViMe2Zr6cyhszUH6e7H3jZuXOx-lpQsx7fmpufzz4PG5Sdz80CQZrwh_WPqCYVUX-hWpG9BK4U3EPlUoRFumFuU-MjsCl3zZzxEye-YvaoqA"/>
                </div>
                <h3 class="text-xl font-bold mb-3">Egrek Sawit</h3>
                <p class="text-gray-500 text-sm mb-6">Egrek sawit premium dengan desain tajam dan gagang teleskopik yang tinggi.</p>
                <a class="text-primary-green font-bold text-sm flex items-center hover:underline" href="{{ route('catalog', ['category' => 'egrek']) }}">
                    LIHAT KOLEKSI 
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </a>
            </div>
            
            <!-- Category Card 2 -->
            <div class="bg-white p-8 rounded-xl card-shadow border border-gray-50 flex flex-col items-start transition hover:scale-105">
                <div class="bg-light-green p-4 rounded-lg mb-6">
                    <img alt="Dodos Sawit Icon" class="h-8 w-8" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaJ07U5vEr8hbs5WaX7NpqSmBypJGUYtDZn0metYvPzmbYVZZfDwSLLM5lsFtl6UP4Lfb8SWw87s5svlsNaF5MK3_7nX_W1qjAB5wnM9aUG5RHK1BlLjtXE5iK0MePPyd5KiknsaUFANk-b2ljUQika5Aj5k9-LroohOP42YtV8WIxg2gVJVjeSXtXjvQ7bYLN1Q4sIOSXr-ovmZhpa1sBGuFdKPT4IXs2jpceTzJvdyQbFb2G2U8OOS2jDOHrNXMfobGp3tv1yw8"/>
                </div>
                <h3 class="text-xl font-bold mb-3">Dodos Sawit</h3>
                <p class="text-gray-500 text-sm mb-6">Dodos sawit dengan baja berkualitas dan presisi tinggi untuk memudahkan panen.</p>
                <a class="text-primary-green font-bold text-sm flex items-center hover:underline" href="{{ route('catalog', ['category' => 'dodos']) }}">
                    LIHAT KOLEKSI 
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </a>
            </div>
            
            <!-- Category Card 3 -->
            <div class="bg-white p-8 rounded-xl card-shadow border border-gray-50 flex flex-col items-start transition hover:scale-105">
                <div class="bg-light-green p-4 rounded-lg mb-6">
                    <img alt="Gagang Teleskopik Icon" class="h-8 w-8" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDE9xWHPFFqy2tGp7kBTpvcTQpmOdVG7-2TtjF0PG3_6vKw0P-OL97yhvWZXwx5FEAEhPAxUNDplw0zG9ATXYBXa-7oByTRQpps7YmosQKcVjA8IlMPJp1w77r6qMybnPwz7WkAoYZsYhER1o-ynM8iszVDKzPHwvkKg1bzLR3pmb2Y3B67fA2XZENsO0Brr8LmLI_PWZLVKErTmSTOzV6xUhHGys6iBPXUFDHrrnFFawgKw4FwVLDhfocJwz-jKl5M09jpNsOQK0"/>
                </div>
                <h3 class="text-xl font-bold mb-3">Gagang Teleskopik</h3>
                <p class="text-gray-500 text-sm mb-6">Gagang aluminium kuat dan ringan yang dapat disesuaikan ketinggiannya.</p>
                <a class="text-primary-green font-bold text-sm flex items-center hover:underline" href="{{ route('catalog', ['category' => 'telescopic_pole']) }}">
                    LIHAT KOLEKSI 
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- Rekomendasi Terpopuler --}}
<section class="py-20 bg-gray-50" data-purpose="recommended-products">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Rekomendasi Terpopuler</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            @forelse($featuredProducts as $product)
            <div class="bg-white p-4 rounded-xl card-shadow flex flex-col">
                <div class="aspect-square bg-gray-100 rounded-lg mb-4 overflow-hidden flex items-center justify-center">
                    @if($product->image)
                        <img alt="{{ $product->name }}" class="w-full h-full object-contain p-4" src="{{ $product->image_url }}"/>
                    @else
                        <div class="text-4xl">🌾</div>
                    @endif
                </div>
                <h4 class="font-bold text-sm mb-1 truncate" title="{{ $product->name }}">{{ $product->name }}</h4>
                <p class="text-primary-green font-bold mb-4">{{ $product->formatted_price }}</p>
                
                @if($product->isAvailable())
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" class="w-full bg-primary-green text-white py-2 rounded-md text-sm font-semibold hover:bg-accent-green transition">Beli Sekarang</button>
                </form>
                @else
                <button disabled class="mt-auto w-full bg-gray-200 text-gray-400 py-2 rounded-md text-sm font-semibold cursor-not-allowed">Stok Habis</button>
                @endif
            </div>
            @empty
            <div class="col-span-5 text-center text-gray-500 py-10">Belum ada rekomendasi produk.</div>
            @endforelse

        </div>
    </div>
</section>

{{-- Mengapa Memilih SiPanen --}}
<section class="py-20" data-purpose="features-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-16">Mengapa Memilih SiPanen?</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
            
            <div class="flex flex-col items-center">
                <div class="mb-4 text-primary-green">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </div>
                <h4 class="font-bold">Kualitas Terjamin</h4>
            </div>

            <div class="flex flex-col items-center">
                <div class="mb-4 text-primary-green">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6 0a1 1 0 001 1h2a1 1 0 001-1m-7 0a1 1 0 001 1h2a1 1 0 001-1" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </div>
                <h4 class="font-bold">Pengiriman Handal</h4>
            </div>

            <div class="flex flex-col items-center">
                <div class="mb-4 text-primary-green">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </div>
                <h4 class="font-bold">Pembayaran Instant</h4>
            </div>

            <div class="flex flex-col items-center">
                <div class="mb-4 text-primary-green">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </div>
                <h4 class="font-bold">Garansi Retur</h4>
            </div>

        </div>
    </div>
</section>

{{-- Testimonial Section --}}
<section class="py-20 bg-gray-50 overflow-hidden" data-purpose="testimonial-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-16">Testimonial</h2>
        <div class="relative flex items-center">
            
            {{-- Prev Button --}}
            <button class="absolute left-0 z-10 p-2 text-gray-400 hover:text-gray-900 transition-colors">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full px-12">
                <!-- Testimonial Card 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-8 italic">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor modium untuk labore et delore maom kerja dan melipatgandakan productivity panen kelapa sawit Anda."</p>
                    <div class="flex items-center space-x-3">
                        <img alt="User 1" class="w-10 h-10 rounded-full bg-gray-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAVXeuS7QNe_s-N2HxqH6DZjAw_Yhhqt0_4OSqwJlpviXQqfe4IozR33BHXu13j_01sV9ecDI1KQhChMBclRRCYuzbQmr6y2PrbDYvF8DaOZsxuv64_OOHTdluTbSNkqJdJaQjz_X_l9oozs1lDlvSN6SnoJng72VihWirY548_E8ziYZk0cJSa3CCsr56a1lTnhTF32nVWpTiCKLvhU-tI3LYbgbTC2B2rZSZsuy9Is85xVAYLRWv5q2tgo09iESGWB1nWMgPLIAY"/>
                        <div>
                            <h5 class="font-bold text-sm">Barana</h5>
                            <p class="text-xs text-gray-500">Custom nomor</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial Card 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-8 italic">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor modium untuk labore et delore maom kerja dan melipatgandakan productivity panen kelapa sawit Anda."</p>
                    <div class="flex items-center space-x-3">
                        <img alt="User 2" class="w-10 h-10 rounded-full bg-gray-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQJD49oZwOpoN2S8QlCJABeW1SW4ya7wBsXU97CjMMPHEhJJc21ySLfTXB82cX_QGoP7HI0QdIercvtd2zNzckJu625oOKY77X8C1kzgdOhtPhu3J2iaxwQNA4xX1ytCzUzld12lZmwioj6c-f58CiGK6vcllo5HyYW3FhTbWr2npoNotaFYt506_dhs1nDU2wT5jnvU0DZYjaKBkuTLvBAWN2S8aGZggFcythlKyxZIUQt9IK8hYr4ZS1OQg0PiIAQz6ulmfXC8w"/>
                        <div>
                            <h5 class="font-bold text-sm">Amos</h5>
                            <p class="text-xs text-gray-500">Custom nomor</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial Card 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-8 italic">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor modium untuk labore et delore maom kerja dan melipatgandakan productivity panen kelapa sawit Anda."</p>
                    <div class="flex items-center space-x-3">
                        <img alt="User 3" class="w-10 h-10 rounded-full bg-gray-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuClIxXL2OVPpV9fn8BIWl5A2kjtZCTP-xBShWhgi7yH5wabE0GFJO2sZAFnUXZb36G1DqmAKflaX4wn6kZetKb6O7K5g3H6YkmXRIXQrsn1Gw1E99636RGqFxmC_-da-DAwKJz9Y3AGA8uZbO8GzmcNaCIK7IlEZLpbUNMzmVd_C81EtuhUP-zFCj33TUtQVU8jwxUVEHaOVEF9BrJ8Clpb1InQFIBSK7RqRudRrD0z4RYn4r40SIYbamMP2TDEl22E_xyUn_Ox4h8"/>
                        <div>
                            <h5 class="font-bold text-sm">Mener.simemar</h5>
                            <p class="text-xs text-gray-500">Custom nomor</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Next Button --}}
            <button class="absolute right-0 z-10 p-2 text-gray-400 hover:text-gray-900 transition-colors">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>

        </div>
        
        {{-- Pagination Dots --}}
        <div class="flex justify-center mt-10 space-x-2">
            <span class="w-2 h-2 rounded-full bg-gray-300"></span>
            <span class="w-2 h-2 rounded-full bg-primary-green"></span>
            <span class="w-2 h-2 rounded-full bg-gray-300"></span>
            <span class="w-2 h-2 rounded-full bg-gray-300"></span>
        </div>
    </div>
</section>

@endsection
