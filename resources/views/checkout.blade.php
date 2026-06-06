@extends('layouts.app')
@section('title','Checkout')

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-slate-800 mb-8"><i class="fa-solid fa-credit-card text-green-600 mr-2"></i> Checkout</h1>

        <form action="{{ route('order.place') }}" method="POST">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                <ul class="space-y-1">@foreach($errors->all() as $e)<li class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    {{-- Shipping Info --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-green-600"></i> Informasi Pengiriman
                        </h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Penerima *</label>
                                <input type="text" name="recipient_name" value="{{ old('recipient_name',$user->name) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Telepon *</label>
                                <input type="tel" name="recipient_phone" value="{{ old('recipient_phone',$user->phone) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap *</label>
                                <textarea name="shipping_address" rows="2" required
                                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none">{{ old('shipping_address',$user->address) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kota *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city',$user->city) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Provinsi *</label>
                                <input type="text" name="shipping_province" value="{{ old('shipping_province',$user->province) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kode Pos *</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code',$user->postal_code) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan (opsional)</label>
                                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Catatan untuk penjual..."
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-wallet text-green-600"></i> Metode Pembayaran
                        </h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 border-slate-200">
                                <input type="radio" name="payment_method" value="transfer" checked class="mt-0.5 accent-green-600">
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">Transfer Bank Manual</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Transfer ke rekening kami, lalu upload bukti transfer</p>
                                </div>
                            </label>
                            <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50 border-slate-200">
                                <input type="radio" name="payment_method" value="midtrans" class="mt-0.5 accent-green-600">
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">Midtrans (Online)</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Bayar dengan kartu kredit, dompet digital, atau QRIS</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm sticky top-24">
                        <h2 class="font-bold text-slate-800 mb-5">Pesanan Anda</h2>
                        <div class="space-y-3 mb-5 max-h-60 overflow-y-auto">
                            @foreach($cart as $id => $item)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                    @if($item['image'])
                                    <img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-base">🌾</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-800 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'],0,',','.') }}</p>
                                </div>
                                <p class="text-xs font-bold text-slate-800 flex-shrink-0">Rp {{ number_format($item['price']*$item['quantity'],0,',','.') }}</p>
                            </div>
                            @endforeach
                        </div>
                        <div class="border-t border-slate-100 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Subtotal</span>
                                <span class="font-semibold">Rp {{ number_format($total,0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Ongkos Kirim</span>
                                <span class="text-green-600 font-semibold">Gratis</span>
                            </div>
                            <div class="flex justify-between font-bold text-slate-800 text-base pt-2 border-t border-slate-100">
                                <span>Total</span>
                                <span class="text-green-600 text-lg">Rp {{ number_format($total,0,',','.') }}</span>
                            </div>
                        </div>
                        <button type="submit" class="mt-5 w-full inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                            <i class="fa-solid fa-check"></i> Buat Pesanan
                        </button>
                        <a href="{{ route('cart') }}" class="mt-3 w-full inline-flex items-center justify-center text-sm text-slate-500 hover:text-slate-700 transition-colors">
                            ← Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
