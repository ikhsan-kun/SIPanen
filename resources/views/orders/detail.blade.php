@extends('layouts.app')
@section('title', 'Pesanan #' . $order->order_number . ' — SiPanen')
@section('meta_description', 'Detail pesanan ' . $order->order_number . '. Status: ' . $order->status_label . '. Total: ' . $order->formatted_total)

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="{{ route('orders.history') }}" class="hover:text-green-600 transition-colors">Pesanan Saya</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-700 font-medium">{{ $order->order_number }}</span>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-extrabold text-slate-800">Detail Pesanan</h1>
                <p class="text-xs text-slate-400 mt-1">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            @php
            $statusColorClass = match($order->status_color) {
                'yellow' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'blue'   => 'bg-blue-50 text-blue-700 border-blue-200',
                'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                'purple' => 'bg-purple-50 text-purple-700 border-purple-200',
                'green'  => 'bg-green-50 text-green-700 border-green-200',
                'red'    => 'bg-red-50 text-red-700 border-red-200',
                default  => 'bg-slate-50 text-slate-600 border-slate-200'
            };
            @endphp
            <span class="text-sm font-bold px-4 py-2 rounded-xl border {{ $statusColorClass }} flex items-center gap-2 self-start">
                <span class="w-2 h-2 rounded-full bg-current"></span>
                {{ $order->status_label }}
            </span>
        </div>

        {{-- Status Tracker --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm mb-6 overflow-hidden">
            {{-- Order Number Bar --}}
            <div class="bg-slate-50 border-b border-slate-100 px-6 py-3 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Pesanan</span>
                <span class="font-mono font-bold text-slate-800 text-sm">{{ $order->order_number }}</span>
            </div>
            <div class="p-6">
                @if($order->status === 'cancelled')
                {{-- Cancelled --}}
                <div class="flex items-start gap-4 bg-red-50 border border-red-100 p-4 rounded-xl">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-red-900 text-sm">Pesanan Dibatalkan</h3>
                        <p class="text-xs text-red-700/80 mt-1">Pesanan ini telah dibatalkan. Jika ada pertanyaan silahkan hubungi kami.</p>
                    </div>
                </div>

                @elseif($order->status === 'selesai')
                {{-- Completed --}}
                <div class="flex items-start gap-4 bg-green-50 border border-green-100 p-4 rounded-xl">
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-900 text-sm">Pesanan Selesai</h3>
                        <p class="text-xs text-green-700 mt-1">Terima kasih! Barang telah diterima. Semoga puas dengan produk kami.</p>
                    </div>
                </div>

                @elseif($order->status === 'dikirim')
                {{-- Shipped --}}
                <div class="bg-purple-50 border border-purple-100 p-4 rounded-xl">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-purple-900 text-sm">Paket Sedang Dalam Pengiriman</h3>
                            <p class="text-xs text-purple-700/80 mt-1">Paket telah diserahkan ke jasa ekspedisi. Gunakan nomor resi di bawah untuk melacak pengiriman.</p>
                        </div>
                    </div>
                    @if($order->tracking_number)
                    <div class="bg-white border border-purple-100 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="flex-1">
                            <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block mb-0.5">Nomor Resi</span>
                            <span class="font-mono font-bold text-slate-800">{{ $order->tracking_number }}</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('orders.track', $order->id) }}"
                               class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                                <i class="fa-solid fa-magnifying-glass"></i> Lacak Resi
                            </a>
                            <form action="{{ route('orders.complete', $order->id) }}" method="POST" data-confirm="Apakah Anda yakin barang sudah sampai dan diterima dengan baik? Tindakan ini akan menyelesaikan pesanan." data-confirm-btn="Ya, Selesai" data-confirm-color="#16a34a">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-all shadow-md shadow-green-500/10 hover:-translate-y-0.5">
                                    <i class="fa-solid fa-circle-check"></i> Pesanan Diterima
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="bg-white border border-purple-100 rounded-xl p-4 text-xs text-slate-500">
                        <i class="fa-solid fa-clock mr-1.5 text-purple-400"></i> Nomor resi sedang disiapkan oleh penjual. Anda juga dapat langsung mengonfirmasi jika barang sudah sampai:
                        <form action="{{ route('orders.complete', $order->id) }}" method="POST" class="mt-3" data-confirm="Apakah Anda yakin barang sudah sampai dan diterima dengan baik?" data-confirm-btn="Ya, Selesai" data-confirm-color="#16a34a">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-500 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all">
                                <i class="fa-solid fa-circle-check"></i> Pesanan Diterima
                            </button>
                        </form>
                    </div>
                    @endif

                @elseif($order->payment_status === 'paid' && in_array($order->status, ['confirmed', 'diproses', 'pending']))
                {{-- Being packed --}}
                <div class="flex items-start gap-4 bg-indigo-50 border border-indigo-100 p-4 rounded-xl">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-indigo-900 text-sm">Sedang Dikemas oleh Penjual</h3>
                        <p class="text-xs text-indigo-700/80 mt-1 leading-relaxed">Pembayaran telah diverifikasi. Admin CV. Ekiindo Tegal sedang menyiapkan barang pesanan Anda.</p>
                    </div>
                </div>

                @else
                {{-- Awaiting Payment (unpaid / pending_confirmation) --}}
                <div class="flex items-start gap-4 bg-amber-50 border border-amber-200 p-4 rounded-xl" id="payment-status-banner">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="flex-1">
                        @if($order->payment_status === 'pending_confirmation')
                        <h3 class="font-bold text-amber-900 text-sm">Menunggu Pembayaran</h3>
                        <p class="text-xs text-amber-700/80 mt-1">Midtrans sedang menunggu transfer pembayaran Anda (mis: Virtual Account Bank). Halaman ini akan diperbarui otomatis setelah Anda mentransfer.</p>
                        @else
                        <h3 class="font-bold text-amber-900 text-sm">Belum Dibayar</h3>
                        <p class="text-xs text-amber-700/80 mt-1">Selesaikan pembayaran untuk melanjutkan pemrosesan pesanan Anda.</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">

                {{-- Order Items --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
                        <h2 class="font-bold text-slate-800 text-sm">Produk Dipesan</h2>
                        <span class="text-xs text-slate-400">{{ $order->items->count() }} item</span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 px-6 py-4">
                            <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                                @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover" alt="{{ $item->product->name ?? '' }}">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-xl">🌾</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-slate-800 text-sm truncate">{{ $item->product->name ?? 'Produk telah dihapus' }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item->quantity }} {{ $item->product->unit ?? 'pcs' }} × Rp {{ number_format($item->price,0,',','.') }}</p>
                            </div>
                            <p class="font-bold text-slate-800 text-sm flex-shrink-0">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 space-y-2">
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Subtotal</span>
                            <span class="font-semibold text-slate-700">Rp {{ number_format($order->subtotal,0,',','.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Ongkos Kirim</span>
                            <span class="font-semibold text-green-600">{{ $order->shipping_cost > 0 ? 'Rp '.number_format($order->shipping_cost,0,',','.') : 'Gratis Ongkir' }}</span>
                        </div>
                        <div class="flex justify-between font-extrabold text-slate-800 text-base pt-2 border-t border-slate-100">
                            <span>Total Pembayaran</span>
                            <span class="text-green-600">Rp {{ number_format($order->total_amount,0,',','.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Payment Section --}}
                @if(in_array($order->payment_status, ['unpaid', 'pending_confirmation']) && $order->status !== 'cancelled')
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6" id="payment-section">
                    <h2 class="font-bold text-slate-800 text-sm mb-4">Selesaikan Pembayaran</h2>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-xl p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center text-white flex-shrink-0">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <div>
                                <p class="font-bold text-green-900 text-sm">Bayar via Midtrans</p>
                                <p class="text-xs text-green-700/80">QRIS · GoPay · ShopeePay · VA Bank · Kartu Kredit</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-3 mb-4 flex items-center justify-between border border-green-100/80">
                            <span class="text-xs text-slate-500">Total yang harus dibayar</span>
                            <span class="font-extrabold text-green-600 text-lg">Rp {{ number_format($order->total_amount,0,',','.') }}</span>
                        </div>
                        <button id="pay-btn" onclick="initPayment()"
                                class="w-full bg-green-600 hover:bg-green-500 active:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-md shadow-green-600/20 text-sm">
                            <i class="fa-solid fa-bolt" id="pay-icon"></i>
                            <span id="pay-text">
                                @if($order->midtrans_snap_token)
                                Bayar Sekarang
                                @else
                                Ambil Link Pembayaran
                                @endif
                            </span>
                        </button>
                        <p class="text-center text-[10px] text-slate-400 mt-3 flex items-center justify-center gap-1">
                            <i class="fa-solid fa-shield-halved text-green-500"></i> Transaksi dijamin aman oleh Midtrans (PCI-DSS Certified)
                        </p>
                        
                        <div class="mt-4 pt-4 border-t border-green-200/50">
                            <form action="{{ route('orders.check-status', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-white hover:bg-green-50/50 active:bg-green-100 text-green-700 border border-green-200/80 font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 text-xs">
                                    <i class="fa-solid fa-arrows-rotate"></i> Sudah bayar? Cek Status Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                {{-- Shipping Destination --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h2 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4">Tujuan Pengiriman</h2>
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block mb-0.5">Penerima</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $order->recipient_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">No. Telepon</span>
                            <span class="font-semibold text-slate-700">{{ $order->recipient_phone }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">Alamat</span>
                            <span class="font-medium text-slate-700 leading-relaxed block">{{ $order->shipping_address }}</span>
                            <span class="text-slate-500 block mt-0.5">{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</span>
                        </div>
                    </div>
                </div>

                {{-- Order Info --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h2 class="font-bold text-slate-700 text-xs uppercase tracking-wider mb-4">Info Transaksi</h2>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Metode Bayar</span>
                            <span class="font-semibold text-slate-700">Midtrans (Online)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Status Bayar</span>
                            @php
                            $payBadge = match($order->payment_status) {
                                'paid'                 => 'bg-green-100 text-green-700',
                                'pending_confirmation' => 'bg-amber-100 text-amber-700',
                                'failed'               => 'bg-red-100 text-red-700',
                                default                => 'bg-slate-100 text-slate-600'
                            };
                            @endphp
                            <span class="font-bold px-2 py-0.5 rounded-full text-[10px] {{ $payBadge }}">{{ $order->payment_status_label }}</span>
                        </div>
                        @if($order->paid_at)
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tanggal Bayar</span>
                            <span class="font-semibold text-slate-700">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                        @if($order->notes)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Catatan</span>
                            <span class="font-medium text-slate-700 italic">"{{ $order->notes }}"</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- CTA Back --}}
                <a href="{{ route('orders.history') }}"
                   class="flex items-center justify-center gap-2 w-full border border-slate-200 text-slate-600 font-semibold text-sm py-3 rounded-xl hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
@if(in_array($order->payment_status, ['unpaid', 'pending_confirmation']) && $order->status !== 'cancelled')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
const snapToken = @json($order->midtrans_snap_token);
const refreshUrl = '{{ route('orders.refresh-token', $order) }}';
const checkStatusUrl = '{{ route('orders.check-status', $order) }}';
const csrfToken  = document.querySelector('meta[name="csrf-token"]').content;

function setPayBtnLoading(loading) {
    const btn  = document.getElementById('pay-btn');
    const icon = document.getElementById('pay-icon');
    const text = document.getElementById('pay-text');
    btn.disabled = loading;
    icon.className = loading ? 'fa-solid fa-spinner fa-spin' : 'fa-solid fa-bolt';
    text.textContent = loading ? 'Memproses...' : 'Bayar Sekarang';
}

function openSnap(token) {
    window.snap.pay(token, {
        onSuccess: async function () {
            try {
                await fetch(checkStatusUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                });
            } catch (e) {
                console.error(e);
            }
            window.location.reload();
        },
        onPending: async function () {
            try {
                await fetch(checkStatusUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                });
            } catch (e) {
                console.error(e);
            }
            window.location.reload();
        },
        onError:   function () { alert('Terjadi kesalahan pembayaran. Silakan coba lagi.'); setPayBtnLoading(false); },
        onClose:   function () { setPayBtnLoading(false); },
    });
}

async function initPayment() {
    setPayBtnLoading(true);

    if (snapToken) {
        // We already have a token, use it directly
        openSnap(snapToken);
        return;
    }

    // No token yet (or it's expired) — refresh from server
    try {
        const resp = await fetch(refreshUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        });
        const data = await resp.json();
        if (resp.ok && data.snap_token) {
            openSnap(data.snap_token);
        } else {
            alert(data.error || 'Gagal mengambil link pembayaran. Silakan coba lagi.');
            setPayBtnLoading(false);
        }
    } catch (err) {
        alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
        setPayBtnLoading(false);
    }
}
</script>
@endif
@endpush
