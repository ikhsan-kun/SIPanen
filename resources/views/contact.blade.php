@extends('layouts.app')
@section('title','Kontak')

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Hubungi Kami</span>
            <h1 class="text-3xl lg:text-4xl font-bold text-slate-800 mt-2">Kami Siap Membantu Anda</h1>
            <p class="text-slate-500 mt-3 max-w-xl mx-auto">Punya pertanyaan tentang produk atau ingin berkonsultasi? Jangan ragu untuk menghubungi kami.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-5">
                @foreach([
                    ['icon'=>'fa-location-dot','title'=>'Alamat','val'=>'Jl. Raya Tegal No. 123, Kota Tegal, Jawa Tengah 52113','color'=>'bg-green-50 text-green-600'],
                    ['icon'=>'fa-phone','title'=>'Telepon / WhatsApp','val'=>'+62 812-3456-7890','color'=>'bg-blue-50 text-blue-600'],
                    ['icon'=>'fa-envelope','title'=>'Email','val'=>'info@ekiindo.com','color'=>'bg-purple-50 text-purple-600'],
                    ['icon'=>'fa-clock','title'=>'Jam Operasional','val'=>'Senin–Sabtu: 08.00–17.00 WIB','color'=>'bg-orange-50 text-orange-600'],
                ] as $c)
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-start gap-4">
                    <div class="w-11 h-11 {{ $c['color'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid {{ $c['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">{{ $c['title'] }}</p>
                        <p class="text-slate-600 text-sm mt-0.5">{{ $c['val'] }}</p>
                    </div>
                </div>
                @endforeach
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="w-full flex items-center justify-center gap-3 bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-2xl transition-all hover:-translate-y-0.5 shadow-lg shadow-green-500/30">
                    <i class="fa-brands fa-whatsapp text-xl"></i> Chat di WhatsApp
                </a>
            </div>

            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Kirim Pesan</h2>
                <form class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" placeholder="Nama Anda" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <input type="email" placeholder="email@contoh.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Subjek</label>
                        <input type="text" placeholder="Topik pesan Anda" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pesan</label>
                        <textarea rows="5" placeholder="Tuliskan pesan Anda di sini..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                    </div>
                    <button type="button" onclick="alert('Fitur pengiriman pesan akan segera hadir. Silakan hubungi kami via WhatsApp.')" class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
