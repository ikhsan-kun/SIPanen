@extends(request()->is('admin/*') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Lacak Pengiriman - ' . $order->order_number)

@section('page-title', 'Lacak Pengiriman')
@section('page-subtitle', 'Pesanan: ' . $order->order_number)

@section('content')
<div class="{{ request()->is('admin/*') ? '' : 'pt-24 min-h-screen bg-slate-50' }}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        {{-- Back Button --}}
        <div class="mb-6">
            @if(request()->is('admin/*'))
            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Detail Pesanan Admin
            </a>
            @else
            <a href="{{ route('orders.detail', $order->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Detail Pesanan
            </a>
            @endif
        </div>

        {{-- Main Tracking Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
            
            {{-- Header Card --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-green-600 uppercase tracking-widest block mb-1">Status Pengiriman</span>
                    <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-green-600"></i> {{ $trackingData['status_paket'] }}
                    </h1>
                </div>
                <div class="flex flex-wrap items-center gap-6 text-sm">
                    <div>
                        <span class="text-slate-400 block text-xs">Ekspedisi</span>
                        <span class="font-bold text-slate-700">{{ $trackingData['courier'] }} ({{ $trackingData['service'] }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-xs">Nomor Resi</span>
                        <span class="font-mono font-bold text-slate-800">{{ $order->tracking_number }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 grid md:grid-cols-3 gap-8">
                
                {{-- Delivery details --}}
                <div class="md:col-span-1 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Informasi Penerima</h3>
                        <p class="font-bold text-slate-800 text-sm">{{ $order->recipient_name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $order->recipient_phone }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Pengiriman</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }}, {{ $order->shipping_postal_code }}
                        </p>
                    </div>

                    @if($trackingData['status'] === 'demo')
                    <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xs p-4 rounded-xl space-y-1.5">
                        <p class="font-semibold"><i class="fa-solid fa-circle-info mr-1"></i> Mode Simulasi (Demo)</p>
                        <p class="text-amber-700/95 leading-relaxed">Anda melihat data simulasi pergerakan paket. Untuk menghubungkan ke pelacakan kurir nyata, silakan daftarkan API Key Binderbyte Anda di file <code>.env</code>.</p>
                    </div>
                    @endif
                </div>

                {{-- Timeline --}}
                <div class="md:col-span-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-6">Riwayat Perjalanan Paket</h3>
                    
                    @if(in_array($trackingData['status'], ['invalid_awb', 'error']))
                    <div class="bg-red-50 border border-red-200 text-red-850 p-5 rounded-2xl flex items-start gap-4 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-red-100 text-red-650 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-red-900 mb-1">Nomor Resi Tidak Sesuai</h4>
                            <p class="text-xs text-red-700 leading-relaxed">{{ $trackingData['message'] }}</p>
                            <p class="text-xs text-slate-500 mt-3">Silakan periksa kembali nomor resi yang diinput atau hubungi pihak ekspedisi terkait apabila nomor resi baru saja diterbitkan.</p>
                        </div>
                    </div>
                    @else
                    <div class="relative pl-6 border-l-2 border-slate-100 space-y-8">
                        @foreach(array_reverse($trackingData['history']) as $index => $history)
                        @php
                        $isFirst = $index === 0;
                        @endphp
                        <div class="relative">
                            {{-- Dot Indicator --}}
                            <div class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full border-4 border-white flex items-center justify-center shadow-sm {{ $isFirst ? 'bg-green-600 ring-4 ring-green-100' : 'bg-slate-300' }}"></div>
                            
                            {{-- Info --}}
                            <div>
                                <span class="text-[10px] font-bold {{ $isFirst ? 'text-green-600' : 'text-slate-400' }} tracking-wide block mb-1">
                                    {{ \Carbon\Carbon::parse($history['date'])->format('d M Y - H:i') }} WIB
                                </span>
                                <p class="text-sm font-semibold {{ $isFirst ? 'text-slate-800' : 'text-slate-600' }} leading-relaxed">
                                    {{ $history['desc'] }}
                                </p>
                                @if(!empty($history['location']))
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-400 mt-1">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i> {{ $history['location'] }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
