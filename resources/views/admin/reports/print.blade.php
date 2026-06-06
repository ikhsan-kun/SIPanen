<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan — CV. Ekiindo Tegal</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size:12px; color:#1e293b; padding:20px; }
        .header { text-align:center; border-bottom:2px solid #16a34a; padding-bottom:16px; margin-bottom:20px; }
        .header h1 { font-size:20px; font-weight:700; color:#15803d; }
        .header p { color:#64748b; font-size:11px; margin-top:4px; }
        .meta-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:20px; }
        .meta-card { background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px; text-align:center; }
        .meta-card .value { font-size:16px; font-weight:700; color:#1e293b; }
        .meta-card .label { font-size:10px; color:#64748b; margin-top:2px; }
        table { width:100%; border-collapse:collapse; margin-bottom:16px; }
        thead th { background:#15803d; color:white; padding:8px 12px; text-align:left; font-size:11px; }
        tbody tr { border-bottom:1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background:#f8fafc; }
        tbody td { padding:8px 12px; }
        tfoot td { padding:10px 12px; background:#dcfce7; font-weight:700; border-top:2px solid #16a34a; }
        .text-right { text-align:right; }
        .footer { margin-top:24px; text-align:center; color:#94a3b8; font-size:10px; border-top:1px solid #e2e8f0; padding-top:12px; }
        .signature-area { display:grid; grid-template-columns:1fr 1fr; gap:40px; margin-top:40px; }
        .signature-box { text-align:center; }
        .signature-line { border-bottom:1px solid #94a3b8; margin-bottom:6px; height:50px; }
        @media print {
            body { padding:10px; }
            @page { margin:15mm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>CV. Ekiindo Tegal — Sistem Informasi Penjualan SiPanen</p>
        <p>Jl. Raya Tegal, Kota Tegal, Jawa Tengah | Telp: +62 812-3456-7890</p>
        <p style="margin-top:8px;font-weight:600;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <div class="meta-grid">
        <div class="meta-card">
            <div class="value">{{ $totalOrders }}</div>
            <div class="label">Total Pesanan</div>
        </div>
        <div class="meta-card">
            <div class="value">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
            <div class="label">Total Pendapatan</div>
        </div>
        <div class="meta-card">
            <div class="value">{{ $totalOrders > 0 ? 'Rp '.number_format($totalRevenue/$totalOrders,0,',','.') : '-' }}</div>
            <div class="label">Rata-rata per Pesanan</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Alamat Pengiriman</th>
                <th>Tanggal</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $i => $order)
            <tr>
                <td>{{ $i+1 }}</td>
                <td style="font-family:monospace;font-size:10px;">{{ $order->order_number }}</td>
                <td>{{ $order->user->name }}</td>
                <td style="font-size:10px;">{{ $order->shipping_city }}, {{ $order->shipping_province }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td class="text-right">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:20px;color:#94a3b8;">Tidak ada data untuk periode ini.</td></tr>
            @endforelse
        </tbody>
        @if($orders->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="5">TOTAL KESELURUHAN</td>
                <td class="text-right">Rp {{ number_format($totalRevenue,0,',','.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="signature-area">
        <div class="signature-box">
            <p style="font-size:11px;color:#64748b;">Dicetak oleh,</p>
            <div class="signature-line"></div>
            <p style="font-size:11px;font-weight:600;">{{ Auth::user()->name }}</p>
            <p style="font-size:10px;color:#64748b;">Administrator</p>
        </div>
        <div class="signature-box">
            <p style="font-size:11px;color:#64748b;">Mengetahui,</p>
            <div class="signature-line"></div>
            <p style="font-size:11px;font-weight:600;">Pimpinan CV. Ekiindo Tegal</p>
        </div>
    </div>

    <div class="footer">
        <p>Laporan dicetak pada {{ now()->format('d M Y, H:i') }} WIB | SiPanen — CV. Ekiindo Tegal</p>
    </div>

    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
