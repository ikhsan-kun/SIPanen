@extends('layouts.app')
@section('title','Konfirmasi Pembayaran')

@section('content')
<div class="pt-24 min-h-screen bg-slate-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('orders.detail',$order->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Detail Pesanan
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Konfirmasi Pembayaran</h1>
        <p class="text-slate-500 text-sm mb-8">Pesanan: <span class="font-mono font-semibold text-slate-700">{{ $order->order_number }}</span></p>

        {{-- Bank Info --}}
        <div class="bg-green-600 rounded-2xl p-6 mb-6 text-white">
            <p class="text-green-100 text-sm mb-4"><i class="fa-solid fa-info-circle mr-1"></i> Transfer pembayaran ke rekening berikut:</p>
            <div class="space-y-2">
                <div class="flex justify-between"><span class="text-green-200 text-sm">Bank</span><span class="font-bold">BCA</span></div>
                <div class="flex justify-between"><span class="text-green-200 text-sm">No. Rekening</span><span class="font-bold font-mono">1234-5678-9012</span></div>
                <div class="flex justify-between"><span class="text-green-200 text-sm">Atas Nama</span><span class="font-bold">CV. Ekiindo Tegal</span></div>
                <div class="flex justify-between border-t border-green-500 pt-2 mt-2"><span class="text-green-200 text-sm">Jumlah Transfer</span><span class="font-bold text-lg">Rp {{ number_format($order->total_amount,0,',','.') }}</span></div>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('orders.submit-confirm-payment',$order->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Bank *</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}" required placeholder="cth. BCA, Mandiri, BNI"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Atas Nama *</label>
                    <input type="text" name="account_name" value="{{ old('account_name') }}" required placeholder="Nama sesuai rekening"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Rekening *</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jumlah Transfer *</label>
                    <input type="number" name="amount_paid" value="{{ old('amount_paid',$order->total_amount) }}" required min="1"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Transfer *</label>
                <input type="date" name="transfer_date" value="{{ old('transfer_date',date('Y-m-d')) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Bukti Transfer *</label>
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-green-400 transition-colors cursor-pointer" onclick="document.getElementById('proof-file').click()">
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2"></i>
                    <p class="text-sm text-slate-600">Klik atau seret file ke sini</p>
                    <p class="text-xs text-slate-400 mt-1">JPG, PNG, maks. 2MB</p>
                    <p id="file-name" class="text-xs text-green-600 mt-2 font-semibold hidden"></p>
                </div>
                <input type="file" id="proof-file" name="transfer_proof" accept="image/*" required class="hidden"
                       onchange="document.getElementById('file-name').textContent=this.files[0].name; document.getElementById('file-name').classList.remove('hidden')">
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Konfirmasi
            </button>
        </form>
    </div>
</div>
@endsection
