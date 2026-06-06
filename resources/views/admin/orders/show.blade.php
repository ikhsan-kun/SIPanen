@extends('layouts.admin')
@section('title','Detail Pesanan')
@section('page-title','Detail Pesanan')
@section('page-subtitle','#'.$order->order_number)

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        {{-- Items --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4">Item Pesanan</h2>
            <div class="divide-y divide-slate-50">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 py-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                        @if($item->product && $item->product->image)<img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                        @else<div class="w-full h-full flex items-center justify-center">🌾</div>@endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-800 text-sm">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                        <p class="text-xs text-slate-500">{{ $item->quantity }} × Rp {{ number_format($item->price,0,',','.') }}</p>
                    </div>
                    <p class="font-bold text-slate-800">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="border-t border-slate-100 pt-4 mt-2 space-y-2">
                <div class="flex justify-between text-sm"><span class="text-slate-500">Subtotal</span><span class="font-semibold">Rp {{ number_format($order->subtotal,0,',','.') }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-slate-500">Ongkir</span><span class="font-semibold">{{ $order->shipping_cost > 0 ? 'Rp '.number_format($order->shipping_cost,0,',','.') : 'Gratis' }}</span></div>
                <div class="flex justify-between font-bold text-slate-800 pt-2 border-t border-slate-100 text-base"><span>Total</span><span class="text-green-600">Rp {{ number_format($order->total_amount,0,',','.') }}</span></div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4">Update Status Pesanan</h2>
            <form action="{{ route('admin.orders.update-status',$order->id) }}" method="POST" class="flex flex-wrap items-center gap-3">
                @csrf @method('PATCH')
                <select name="status" class="flex-1 min-w-40 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    @foreach(['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
                    <option value="{{ $v }}" {{ $order->status===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold rounded-xl transition-all hover:-translate-y-0.5 shadow-md shadow-green-500/30">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Status
                </button>
            </form>
        </div>

        {{-- Payment Confirmation --}}
        @if($order->paymentConfirmation)
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4">Konfirmasi Pembayaran</h2>
            <div class="grid sm:grid-cols-2 gap-4 mb-4">
                <div class="p-3 bg-slate-50 rounded-xl"><p class="text-xs text-slate-400 mb-0.5">Bank</p><p class="font-semibold text-sm">{{ $order->paymentConfirmation->bank_name }}</p></div>
                <div class="p-3 bg-slate-50 rounded-xl"><p class="text-xs text-slate-400 mb-0.5">Atas Nama</p><p class="font-semibold text-sm">{{ $order->paymentConfirmation->account_name }}</p></div>
                <div class="p-3 bg-slate-50 rounded-xl"><p class="text-xs text-slate-400 mb-0.5">No. Rekening</p><p class="font-semibold text-sm">{{ $order->paymentConfirmation->account_number }}</p></div>
                <div class="p-3 bg-slate-50 rounded-xl"><p class="text-xs text-slate-400 mb-0.5">Jumlah Transfer</p><p class="font-semibold text-sm">Rp {{ number_format($order->paymentConfirmation->amount_paid,0,',','.') }}</p></div>
                <div class="p-3 bg-slate-50 rounded-xl"><p class="text-xs text-slate-400 mb-0.5">Tanggal</p><p class="font-semibold text-sm">{{ $order->paymentConfirmation->transfer_date->format('d M Y') }}</p></div>
                <div class="p-3 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-0.5">Status</p>
                    @php $cs=['pending'=>'text-orange-600','approved'=>'text-green-600','rejected'=>'text-red-600']; @endphp
                    <p class="font-semibold text-sm {{ $cs[$order->paymentConfirmation->status]??'text-slate-700' }}">{{ ucfirst($order->paymentConfirmation->status) }}</p>
                </div>
            </div>
            <a href="{{ asset('storage/'.$order->paymentConfirmation->transfer_proof) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700 mb-4">
                <i class="fa-solid fa-image"></i> Lihat Bukti Transfer
            </a>
            @if($order->paymentConfirmation->status === 'pending')
            <form action="{{ route('admin.orders.confirm-payment',$order->paymentConfirmation->id) }}" method="POST" class="border-t border-slate-100 pt-4 space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan Admin (opsional)</label>
                    <textarea name="admin_notes" rows="2" placeholder="Catatan untuk pelanggan..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" name="action" value="approve" class="flex-1 bg-green-600 hover:bg-green-500 text-white font-semibold py-3 rounded-xl transition-all hover:-translate-y-0.5 text-sm shadow-md shadow-green-500/30">
                        <i class="fa-solid fa-check mr-1"></i> Konfirmasi Pembayaran
                    </button>
                    <button type="submit" name="action" value="reject" class="flex-1 bg-red-600 hover:bg-red-500 text-white font-semibold py-3 rounded-xl transition-all text-sm"
                            onclick="return confirm('Yakin menolak konfirmasi ini?')">
                        <i class="fa-solid fa-xmark mr-1"></i> Tolak
                    </button>
                </div>
            </form>
            @endif
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4 text-sm">Informasi Pelanggan</h2>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">{{ strtoupper(substr($order->user->name,0,1)) }}</div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">{{ $order->user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                </div>
            </div>
            <a href="{{ route('admin.customers.show',$order->user->id) }}" class="text-xs font-semibold text-green-600 hover:text-green-700">Lihat Profil →</a>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4 text-sm">Informasi Pengiriman</h2>
            <div class="space-y-2 text-sm">
                <div><p class="text-xs text-slate-400">Penerima</p><p class="font-semibold text-slate-800">{{ $order->recipient_name }}</p></div>
                <div><p class="text-xs text-slate-400">Telepon</p><p class="font-semibold text-slate-800">{{ $order->recipient_phone }}</p></div>
                <div><p class="text-xs text-slate-400">Alamat</p><p class="text-slate-700">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4 text-sm">Timeline Pesanan</h2>
            <div class="space-y-3">
                <div class="flex items-start gap-3 text-sm"><div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 flex-shrink-0"></div><div><p class="font-medium text-slate-700">Pesanan Dibuat</p><p class="text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</p></div></div>
                @if($order->paid_at)<div class="flex items-start gap-3 text-sm"><div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 flex-shrink-0"></div><div><p class="font-medium text-slate-700">Pembayaran Dikonfirmasi</p><p class="text-xs text-slate-400">{{ $order->paid_at->format('d M Y, H:i') }}</p></div></div>@endif
                @if($order->shipped_at)<div class="flex items-start gap-3 text-sm"><div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 flex-shrink-0"></div><div><p class="font-medium text-slate-700">Pesanan Dikirim</p><p class="text-xs text-slate-400">{{ $order->shipped_at->format('d M Y, H:i') }}</p></div></div>@endif
                @if($order->completed_at)<div class="flex items-start gap-3 text-sm"><div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 flex-shrink-0"></div><div><p class="font-medium text-slate-700">Pesanan Selesai</p><p class="text-xs text-slate-400">{{ $order->completed_at->format('d M Y, H:i') }}</p></div></div>@endif
            </div>
        </div>
    </div>
</div>
@endsection
