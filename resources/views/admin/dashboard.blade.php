@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-subtitle','Ringkasan data dan aktivitas terbaru')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    @foreach([
        ['icon'=>'fa-sack-dollar','label'=>'Total Pendapatan','value'=>'Rp '.number_format($totalRevenue,0,',','.'),'sub'=>'Dari pesanan lunas','color'=>'bg-green-500','bg'=>'bg-green-50'],
        ['icon'=>'fa-file-invoice','label'=>'Total Pesanan','value'=>$totalOrders,'sub'=>$pendingOrders.' pesanan pending','color'=>'bg-blue-500','bg'=>'bg-blue-50'],
        ['icon'=>'fa-box-open','label'=>'Total Produk','value'=>$totalProducts,'sub'=>count($lowStockProducts).' stok menipis','color'=>'bg-purple-500','bg'=>'bg-purple-50'],
        ['icon'=>'fa-users','label'=>'Total Pelanggan','value'=>$totalCustomers,'sub'=>'Pelanggan terdaftar','color'=>'bg-orange-500','bg'=>'bg-orange-50'],
    ] as $s)
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 {{ $s['bg'] }} rounded-xl flex items-center justify-center">
                <i class="fa-solid {{ $s['icon'] }} {{ str_replace('bg-','text-',$s['color']) }} text-lg"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800 mb-1">{{ $s['value'] }}</p>
        <p class="text-sm text-slate-500 font-medium">{{ $s['label'] }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $s['sub'] }}</p>
    </div>
    @endforeach
</div>

{{-- Alerts --}}
@if($ordersToShip > 0)
<div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 mb-6 flex items-center gap-3">
    <i class="fa-solid fa-box-open text-indigo-500 text-lg"></i>
    <div class="flex-1">
        <p class="font-semibold text-indigo-800 text-sm">{{ $ordersToShip }} pesanan baru telah dibayar & perlu dikemas / dikirim</p>
    </div>
    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-100 px-3.5 py-2 rounded-lg transition-colors">Proses Pengiriman</a>
</div>
@endif

@if($lowStockProducts->isNotEmpty())
<div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
    <div class="flex items-center gap-2 mb-2">
        <i class="fa-solid fa-box-open text-amber-500"></i>
        <p class="font-semibold text-amber-800 text-sm">Stok produk menipis (≤5)</p>
    </div>
    <div class="flex flex-wrap gap-2">
        @foreach($lowStockProducts as $p)
        <span class="text-xs bg-white border border-amber-200 text-amber-700 px-3 py-1 rounded-full">{{ $p->name }} ({{ $p->stock }})</span>
        @endforeach
    </div>
</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Revenue Chart --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <h2 class="font-bold text-slate-800 mb-5">Pendapatan Bulanan {{ now()->year }}</h2>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    {{-- Orders by Status --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <h2 class="font-bold text-slate-800 mb-5">Status Pesanan</h2>
        <canvas id="statusChart" height="160"></canvas>
        <div class="mt-4 space-y-2">
            @foreach($ordersByStatus as $status => $count)
            @php
            $labels = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai','cancelled'=>'Dibatalkan'];
            $colors = ['pending'=>'bg-yellow-400','confirmed'=>'bg-blue-400','diproses'=>'bg-indigo-400','dikirim'=>'bg-purple-400','selesai'=>'bg-green-400','cancelled'=>'bg-red-400'];
            @endphp
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full {{ $colors[$status] ?? 'bg-slate-400' }}"></div><span class="text-slate-600">{{ $labels[$status] ?? $status }}</span></div>
                <span class="font-bold text-slate-800">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-green-600 hover:text-green-700 transition-colors">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Pesanan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentOrders as $order)
                    @php
                    $statusColorClass = match($order->status_color) {
                        'yellow' => 'bg-yellow-100 text-yellow-700',
                        'blue' => 'bg-blue-100 text-blue-700',
                        'indigo' => 'bg-indigo-100 text-indigo-700',
                        'purple' => 'bg-purple-100 text-purple-700',
                        'green' => 'bg-green-100 text-green-700',
                        'red' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-600'
                    };
                    $pc = match($order->payment_status) {
                        'paid' => 'bg-green-100 text-green-700',
                        'pending_confirmation' => 'bg-orange-100 text-orange-700',
                        'unpaid' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-600'
                    };
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-3.5 font-mono font-semibold text-slate-700 text-xs">{{ $order->order_number }}</td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xs font-bold flex-shrink-0">{{ strtoupper(substr($order->user->name,0,1)) }}</div>
                                <span class="text-slate-700 font-medium">{{ Str::limit($order->user->name,20) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 font-bold text-slate-800">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                        <td class="px-6 py-3.5"><span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColorClass }}">{{ $order->status_label }}</span></td>
                        <td class="px-6 py-3.5"><span class="text-xs font-semibold px-2 py-1 rounded-full {{ $pc }}">{{ $order->payment_status_label }}</span></td>
                        <td class="px-6 py-3.5 text-slate-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3.5"><a href="{{ route('admin.orders.show',$order->id) }}" class="text-green-600 hover:text-green-700 font-semibold text-xs">Detail →</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const revenueData = @json($revenueData);

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: revenueData,
            backgroundColor: 'rgba(22,163,74,0.15)',
            borderColor: '#16a34a',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: v => 'Rp '+Intl.NumberFormat('id').format(v) }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});

const statusData = @json($ordersByStatus);
const statusLabels = { pending:'Menunggu',confirmed:'Dikonfirmasi',diproses:'Diproses',dikirim:'Dikirim',selesai:'Selesai',cancelled:'Dibatalkan' };
const statusColors = { pending:'#facc15',confirmed:'#60a5fa',diproses:'#818cf8',dikirim:'#c084fc',selesai:'#4ade80',cancelled:'#f87171' };
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(k => statusLabels[k] || k),
        datasets: [{ data: Object.values(statusData), backgroundColor: Object.keys(statusData).map(k => statusColors[k]||'#94a3b8'), borderWidth: 0 }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, cutout: '70%' }
});
</script>
@endpush
