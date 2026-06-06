@extends('layouts.app')
@section('title','Keranjang Belanja')

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-slate-800 mb-8">
            <i class="fa-solid fa-cart-shopping text-green-600 mr-2"></i> Keranjang Belanja
        </h1>

        @if(empty($cart))
        <div class="bg-white rounded-3xl border border-slate-100 p-16 text-center shadow-sm">
            <div class="text-7xl mb-4">🛒</div>
            <h2 class="text-xl font-bold text-slate-700 mb-2">Keranjang Masih Kosong</h2>
            <p class="text-slate-500 mb-6">Yuk, mulai belanja alat panen kelapa sawit pilihan!</p>
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-store"></i> Lihat Katalog
            </a>
        </div>
        @else
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-20 h-20 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                        @if($item['image'])
                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-2xl">🌾</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-800 truncate">{{ $item['name'] }}</h3>
                        <p class="text-green-600 font-semibold text-sm mt-0.5">Rp {{ number_format($item['price'],0,',','.') }} / {{ $item['unit'] }}</p>
                        <p class="text-xs text-slate-400 mt-1">Stok: {{ $item['stock'] }} {{ $item['unit'] }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('cart.update',$id) }}" method="POST" class="flex items-center border border-slate-200 rounded-xl overflow-hidden">
                            @csrf @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item['quantity']-1 }}" class="px-3 py-2 text-slate-600 hover:bg-slate-100 transition-colors font-bold text-sm">−</button>
                            <span class="px-3 py-2 text-sm font-semibold border-x border-slate-200 min-w-10 text-center">{{ $item['quantity'] }}</span>
                            <button type="submit" name="quantity" value="{{ $item['quantity']+1 }}" class="px-3 py-2 text-slate-600 hover:bg-slate-100 transition-colors font-bold text-sm">+</button>
                        </form>
                        <div class="text-right min-w-28">
                            <p class="font-bold text-slate-800">Rp {{ number_format($item['price']*$item['quantity'],0,',','.') }}</p>
                        </div>
                        <form action="{{ route('cart.remove',$id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm sticky top-24">
                    <h2 class="font-bold text-slate-800 mb-5 text-lg">Ringkasan Pesanan</h2>
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>Subtotal ({{ count($cart) }} produk)</span>
                            <span class="font-semibold">Rp {{ number_format($total,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Ongkos Kirim</span>
                            <span class="text-green-600 font-semibold">Dihitung saat checkout</span>
                        </div>
                    </div>
                    <div class="border-t border-slate-100 pt-4 mb-5">
                        <div class="flex justify-between font-bold text-slate-800">
                            <span>Total</span>
                            <span class="text-green-600 text-lg">Rp {{ number_format($total,0,',','.') }}</span>
                        </div>
                    </div>
                    @auth
                    <a href="{{ route('checkout') }}" class="w-full inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                        <i class="fa-solid fa-credit-card"></i> Lanjut Checkout
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all">
                        <i class="fa-solid fa-right-to-bracket"></i> Login untuk Checkout
                    </a>
                    @endauth
                    <a href="{{ route('catalog') }}" class="w-full mt-3 inline-flex items-center justify-center gap-2 border border-slate-200 text-slate-600 font-semibold py-3 rounded-xl hover:bg-slate-50 transition-colors text-sm">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
