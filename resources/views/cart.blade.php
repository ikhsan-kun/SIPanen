@extends('layouts.app')
@section('title','Keranjang Belanja — SiPanen')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-primary-green transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-75"></i>
                    <span class="text-gray-700 font-medium">Keranjang</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-8 h-8 bg-primary-green rounded-md flex items-center justify-center text-white flex-shrink-0">
                        <i class="fa-solid fa-cart-shopping text-sm"></i>
                    </span>
                    <span>Keranjang Belanja</span>
                </h1>
            </div>
            @if(!empty($cart))
            <span class="text-xs text-gray-500">{{ count($cart) }} produk</span>
            @endif
        </div>

        @if(empty($cart))
        {{-- Empty state --}}
        <div class="bg-white rounded-lg border border-gray-200 p-16 text-center card-shadow">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl">🛒</div>
            <h2 class="text-lg font-bold text-gray-900 mb-2">Keranjang Masih Kosong</h2>
            <p class="text-gray-500 mb-6 text-sm">Yuk, mulai belanja alat panen kelapa sawit pilihan!</p>
            <a href="{{ route('catalog') }}"
               class="inline-flex items-center space-x-2 bg-primary-green hover:bg-accent-green text-white font-bold px-6 py-2.5 rounded-md transition text-sm">
                <i class="fa-solid fa-store"></i> 
                <span>Lihat Katalog</span>
            </a>
        </div>

        @else
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Cart items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                <div class="bg-white rounded-lg border border-gray-200 p-5 flex items-center space-x-4 card-shadow">
                    {{-- Image --}}
                    <div class="w-16 h-16 rounded-md bg-gray-50 overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                        @if($item['image'])
                        <img src="{{ file_exists(public_path($item['image'])) ? asset($item['image']) : asset('storage/'.$item['image']) }}"
                             alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-2xl">🌾</div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 truncate text-sm leading-none">{{ $item['name'] }}</h3>
                        <p class="text-primary-green font-bold text-sm mt-2 leading-none">Rp {{ number_format($item['price'],0,',','.') }}</p>
                        <p class="text-[10px] text-gray-400 mt-2">per {{ $item['unit'] }} · Stok: {{ $item['stock'] }}</p>
                    </div>

                    {{-- Qty & total --}}
                    <div class="flex items-center space-x-4 flex-shrink-0">
                        <form action="{{ route('cart.update', $id) }}" method="POST"
                              class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-white">
                            @csrf @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                    class="px-2 py-1 text-gray-600 hover:bg-gray-50 font-bold text-sm">−</button>
                            <span class="px-3 py-1 text-xs font-bold border-x border-gray-300 min-w-[32px] text-center">{{ $item['quantity'] }}</span>
                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                    class="px-2 py-1 text-gray-600 hover:bg-gray-50 font-bold text-sm">+</button>
                        </form>
                        <div class="text-right min-w-[100px]">
                            <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($item['price'] * $item['quantity'],0,',','.') }}</p>
                        </div>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition" title="Hapus">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                <a href="{{ route('catalog') }}"
                   class="inline-flex items-center space-x-1.5 text-xs text-gray-500 hover:text-primary-green transition-colors mt-2">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> 
                    <span>Lanjut Belanja</span>
                </a>
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 p-6 card-shadow sticky top-24">
                    <h2 class="font-bold text-gray-950 mb-5 text-sm uppercase tracking-wider">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Subtotal ({{ count($cart) }} produk)</span>
                            <span class="font-bold text-gray-700">Rp {{ number_format($total,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">Ongkos Kirim</span>
                            <span class="text-primary-green font-semibold text-[10px]">Dihitung saat checkout</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-5">
                        <div class="flex justify-between font-bold text-gray-900 text-sm">
                            <span>Total</span>
                            <span class="text-primary-green text-base">Rp {{ number_format($total,0,',','.') }}</span>
                        </div>
                    </div>

                    @auth
                    <a href="{{ route('checkout') }}"
                       class="w-full inline-flex items-center justify-center space-x-2 bg-primary-green hover:bg-accent-green text-white font-bold py-2.5 rounded-md transition text-sm shadow-sm">
                        <i class="fa-solid fa-credit-card"></i> 
                        <span>Lanjut Checkout</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                       class="w-full inline-flex items-center justify-center space-x-2 bg-primary-green hover:bg-accent-green text-white font-bold py-2.5 rounded-md transition text-sm">
                        <i class="fa-solid fa-right-to-bracket"></i> 
                        <span>Login untuk Checkout</span>
                    </a>
                    @endauth

                    <div class="text-center text-[10px] text-gray-400 mt-4 flex items-center justify-center space-x-1">
                        <i class="fa-solid fa-lock text-primary-green"></i> 
                        <span>Transaksi aman & terenkripsi SSL</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
