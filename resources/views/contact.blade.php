@extends('layouts.app')
@section('title','Kontak — SiPanen')

@section('content')

{{-- Page Header --}}
<div class="border-b border-gray-100 bg-gradient-to-b from-gray-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-green transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
            <span class="text-gray-700 font-medium">Kontak</span>
        </nav>
        <span class="text-primary-green font-bold text-xs uppercase tracking-wider block mb-1">Hubungi Kami</span>
        <h1 class="text-3xl font-bold text-gray-900">Kami Siap Membantu Anda</h1>
        <p class="text-gray-500 mt-2 max-w-xl text-xs leading-relaxed">Punya pertanyaan tentang produk atau ingin berkonsultasi? Jangan ragu untuk menghubungi kami.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Left: Contact Info --}}
        <div class="space-y-4">
            @foreach([
                ['icon'=>'fa-location-dot','title'=>'Alamat',              'val'=>'Jl. Raya Tegal No. 123, Kota Tegal, Jawa Tengah 52113','color'=>'bg-light-green text-primary-dark'],
                ['icon'=>'fa-phone',       'title'=>'Telepon / WhatsApp',  'val'=>'+62 812-3456-7890',                                     'color'=>'bg-blue-50 text-blue-800'],
                ['icon'=>'fa-envelope',    'title'=>'Email',                'val'=>'info@ekiindo.com',                                       'color'=>'bg-purple-50 text-purple-800'],
                ['icon'=>'fa-clock',       'title'=>'Jam Operasional',     'val'=>'Senin–Sabtu: 08.00–17.00 WIB',                          'color'=>'bg-orange-50 text-orange-800'],
            ] as $c)
            <div class="bg-white rounded-lg border border-gray-200 p-5 card-shadow flex items-start space-x-4">
                <div class="w-10 h-10 {{ $c['color'] }} rounded-md flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid {{ $c['icon'] }} text-sm"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm leading-none">{{ $c['title'] }}</p>
                    <p class="text-gray-500 text-xs mt-2 leading-relaxed">{{ $c['val'] }}</p>
                </div>
            </div>
            @endforeach

            <a href="https://wa.me/6281234567890" target="_blank"
               class="w-full flex items-center justify-center space-x-2 bg-primary-green hover:bg-accent-green text-white font-bold py-3 rounded-md transition text-sm shadow-sm mt-2">
                <i class="fa-brands fa-whatsapp text-lg"></i> 
                <span>Chat di WhatsApp</span>
            </a>
        </div>

        {{-- Right: Form --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-8 card-shadow">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Kirim Pesan</h2>
            <form class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" placeholder="Nama Anda"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" placeholder="email@contoh.com"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green bg-white transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Subjek</label>
                    <input type="text" placeholder="Topik pesan Anda"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pesan</label>
                    <textarea rows="4" placeholder="Tuliskan pesan Anda di sini..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-green bg-white transition resize-none"></textarea>
                </div>
                
                <button type="button"
                        onclick="document.getElementById('contact-info').textContent = 'Terima kasih! Untuk menghubungi kami, silakan gunakan WhatsApp atau email langsung ke info@ekiindo.com'; document.getElementById('contact-info').classList.remove('hidden');"
                        class="w-full bg-primary-green hover:bg-accent-green text-white font-bold py-2.5 rounded-xl transition-all hover:shadow-md hover:shadow-green-500/20 text-sm flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Pesan</span>
                </button>
                <p id="contact-info" class="hidden text-center text-xs text-gray-500 mt-3 bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg"></p>
                <div class="text-center text-[10px] text-gray-400 flex items-center justify-center space-x-1 mt-4">
                    <i class="fa-solid fa-lock text-primary-green"></i> 
                    <span>Informasi Anda aman & tidak akan disebarluaskan</span>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
