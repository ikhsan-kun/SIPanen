@extends('layouts.app')
@section('title', 'Checkout — Konfirmasi Pesanan')
@section('meta_description', 'Konfirmasi pesanan dan selesaikan pembayaran melalui Midtrans dengan aman dan mudah.')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
            <a href="{{ route('cart') }}" class="hover:text-green-600 transition-colors">Keranjang</a>
            <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
            <span class="text-slate-800 font-medium">Checkout</span>
        </nav>

        <h1 class="text-2xl font-extrabold text-slate-800 mb-8 flex items-center gap-3">
            <span class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-bag-shopping text-sm"></i>
            </span>
            Konfirmasi Pesanan
        </h1>

        <form action="{{ route('order.place') }}" method="POST" id="checkout-form">
            @csrf
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm" role="alert">
                <ul class="space-y-1">@foreach($errors->all() as $e)<li class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">

                    {{-- Shipping Info --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2 text-base">
                            <i class="fa-solid fa-location-dot text-green-600"></i> Informasi Pengiriman
                        </h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="recipient_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Penerima <span class="text-red-500">*</span></label>
                                <input type="text" id="recipient_name" name="recipient_name"
                                       value="{{ old('recipient_name', $user->name) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label for="recipient_phone" class="block text-sm font-semibold text-slate-700 mb-1.5">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                                <input type="tel" id="recipient_phone" name="recipient_phone"
                                       value="{{ old('recipient_phone', $user->phone) }}" required
                                       placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="shipping_address" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea id="shipping_address" name="shipping_address" rows="2" required
                                          placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan..."
                                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none">{{ old('shipping_address', $user->address) }}</textarea>
                            </div>
                            <div>
                                <label for="shipping_city" class="block text-sm font-semibold text-slate-700 mb-1.5">Kota / Kabupaten <span class="text-red-500">*</span></label>
                                <input type="text" id="shipping_city" name="shipping_city"
                                       value="{{ old('shipping_city', $user->city) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label for="shipping_province" class="block text-sm font-semibold text-slate-700 mb-1.5">Provinsi <span class="text-red-500">*</span></label>
                                <input type="text" id="shipping_province" name="shipping_province"
                                       value="{{ old('shipping_province', $user->province) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label for="shipping_postal_code" class="block text-sm font-semibold text-slate-700 mb-1.5">Kode Pos <span class="text-red-500">*</span></label>
                                <input type="text" id="shipping_postal_code" name="shipping_postal_code"
                                       value="{{ old('shipping_postal_code', $user->postal_code) }}" required
                                       maxlength="5" pattern="[0-9]{5}"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan untuk Penjual</label>
                                <input type="text" id="notes" name="notes"
                                       value="{{ old('notes') }}" placeholder="Opsional. Misal: pintu merah..."
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method (Midtrans only) --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                        <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2 text-base">
                            <i class="fa-solid fa-shield-halved text-green-600"></i> Metode Pembayaran
                        </h2>
                        <div class="flex items-start gap-4 p-4 rounded-xl border-2 border-green-500 bg-green-50">
                            <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center flex-shrink-0 text-white">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">Midtrans — Pembayaran Online Aman</p>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Bayar dengan QRIS, GoPay, ShopeePay, OVO, Dana, Transfer Bank (BCA, Mandiri, BRI, BNI), atau Kartu Kredit/Debit langsung melalui payment gateway bersertifikat PCI-DSS.</p>
                                <div class="flex flex-wrap items-center gap-1.5 mt-3">
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-green-600/10 text-green-700 rounded-md border border-green-600/20 uppercase tracking-wider">QRIS</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-blue-500/10 text-blue-700 rounded-md border border-blue-500/20 uppercase tracking-wider">GoPay</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md border border-slate-200 uppercase tracking-wider">ShopeePay</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md border border-slate-200 uppercase tracking-wider">Transfer Bank</span>
                                    <span class="text-[10px] text-slate-400 font-medium ml-1">+ Metode Lainnya</span>
                                </div>
                            </div>
                        </div>
                        {{-- Hidden input so validation still passes --}}
                        <input type="hidden" name="payment_method" value="midtrans">
                    </div>

                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm sticky top-24">
                        <h2 class="font-bold text-slate-800 mb-5 text-base">Ringkasan Pesanan</h2>
                        <div class="space-y-3 mb-5 max-h-64 overflow-y-auto pr-1">
                            @foreach($cart as $id => $item)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                                    @if($item['image'])
                                    <img src="{{ file_exists(public_path($item['image'])) ? asset($item['image']) : asset('storage/'.$item['image']) }}" class="w-full h-full object-cover" alt="{{ $item['name'] }}">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-base">🌾</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-800 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $item['quantity'] }} × Rp {{ number_format($item['price'],0,',','.') }}</p>
                                </div>
                                <p class="text-xs font-bold text-slate-800 flex-shrink-0">Rp {{ number_format($item['price']*$item['quantity'],0,',','.') }}</p>
                            </div>
                            @endforeach
                        </div>
                        <div class="border-t border-slate-100 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Subtotal ({{ count($cart) }} produk)</span>
                                <span class="font-semibold">Rp {{ number_format($total,0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Ongkos Kirim</span>
                                <span class="text-green-600 font-semibold">Gratis</span>
                            </div>
                            <div class="flex justify-between font-extrabold text-slate-800 text-base pt-3 border-t border-slate-100">
                                <span>Total Pembayaran</span>
                                <span class="text-green-600">Rp {{ number_format($total,0,',','.') }}</span>
                            </div>
                        </div>
                        <button type="submit" id="submit-btn"
                                class="mt-5 w-full inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 active:bg-green-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-green-500/20 hover:-translate-y-0.5 text-sm">
                            <i class="fa-solid fa-bolt"></i> Lanjut ke Pembayaran
                        </button>
                        <a href="{{ route('cart') }}" class="mt-3 w-full inline-flex items-center justify-center text-xs text-slate-500 hover:text-slate-700 transition-colors gap-1">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Keranjang
                        </a>
                        <p class="text-center text-[10px] text-slate-400 mt-4 flex items-center justify-center gap-1">
                            <i class="fa-solid fa-lock text-green-500"></i> Transaksi aman & terenkripsi SSL
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('checkout-form').addEventListener('submit', function() {
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
});
</script>
@endpush
