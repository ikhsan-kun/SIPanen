@extends('layouts.app')
@section('title','Tentang Kami')

@section('content')
<div class="pt-24 bg-gradient-to-b from-white to-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
            <div>
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider block mb-2">Profil Perusahaan</span>
                <h1 class="text-3xl lg:text-5xl font-bold text-slate-800 tracking-tight leading-tight mb-6">CV. Ekiindo Tegal</h1>
                <p class="text-slate-600 leading-relaxed mb-5 text-base">CV. Ekiindo Tegal adalah produsen sekaligus distributor terpercaya alat pemanen kelapa sawit berkualitas tinggi. Berlokasi strategis di Kota Tegal, Jawa Tengah, kami mengedepankan kualitas pengerjaan produk yang presisi.</p>
                <p class="text-slate-600 leading-relaxed mb-5 text-base">Dengan pengalaman lebih dari satu dekade, kami berkomitmen menyuplai kebutuhan alat-alat perkebunan sawit baik untuk petani mandiri maupun perusahaan berskala besar di Sumatera, Kalimantan, hingga wilayah Papua.</p>
                
                <div class="grid grid-cols-3 gap-6 mt-10">
                    <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <p class="text-3xl font-extrabold text-green-600">10+</p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">Tahun Pengalaman</p>
                    </div>
                    <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <p class="text-3xl font-extrabold text-green-600">500+</p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">Pelanggan Puas</p>
                    </div>
                    <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                        <p class="text-3xl font-extrabold text-green-600">3</p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">Lini Produk Utama</p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl blur opacity-25"></div>
                <div class="relative bg-gradient-to-br from-green-700 to-emerald-900 rounded-3xl p-10 text-white shadow-xl">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        <i class="fa-solid fa-eye text-green-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Visi Perusahaan</h3>
                    <p class="text-green-100/90 leading-relaxed text-sm">Menjadi mitra utama terpercaya bagi para petani dan industri kelapa sawit di seluruh penjuru Nusantara dengan senantiasa menghadirkan produk inovatif yang mempermudah proses panen serta mengoptimalkan hasil panen secara berkelanjutan.</p>
                    
                    <div class="mt-8 pt-8 border-t border-white/10 flex items-center gap-4 text-xs text-green-200">
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-green-400"></i> Kualitas Baja Premium</div>
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-green-400"></i> Produksi Presisi</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lini Produk Kami --}}
        <div class="mb-24">
            <div class="text-center mb-14">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider block mb-2">Unggulan Produksi</span>
                <h2 class="text-3xl font-bold text-slate-800">Lini Produk Kami</h2>
                <p class="text-slate-500 mt-2 max-w-lg mx-auto">Dirancang dan ditempa secara presisi untuk menjamin efisiensi tinggi saat proses panen sawit.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                    ['icon'=>'fa-scissors','name'=>'Egrek Sawit','desc'=>'Pisau panen melengkung tajam berbahan baja karbon impor premium. Bentuk melengkung yang ergonomis memberikan daya potong maksimal pada pelepah kelapa sawit.'],
                    ['icon'=>'fa-hammer','name'=>'Dodos Sawit','desc'=>'Pahat panen tajam yang dirancang khusus untuk memotong pelepah sawit pada pohon rendah hingga sedang, menjaga ketajaman lebih lama.'],
                    ['icon'=>'fa-arrows-left-right-to-line','name'=>'Gagang Teleskopik','desc'=>'Gagang pipa aluminium alloy tebal yang tangguh namun ringan, memudahkan penyesuaian ketinggian jangkauan pohon kelapa sawit.'],
                ] as $p)
                <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 text-xl mb-6">
                        <i class="fa-solid {{ $p['icon'] }}"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg mb-3">{{ $p['name'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $p['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
