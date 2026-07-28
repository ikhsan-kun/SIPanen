<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Lacak resi untuk halaman customer
     */
    public function track(Order $order)
    {
        // Pastikan order ini milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->tracking_number) {
            return back()->with('error', 'Nomor resi belum diinput oleh penjual.');
        }

        $trackingData = $this->fetchTrackingData($order->tracking_number, $order->shipping_courier);

        return view('orders.tracking', compact('order', 'trackingData'));
    }

    /**
     * Lacak resi untuk halaman admin
     */
    public function trackAdmin(Order $order)
    {
        if (!$order->tracking_number) {
            return back()->with('error', 'Nomor resi belum diinput.');
        }

        $trackingData = $this->fetchTrackingData($order->tracking_number, $order->shipping_courier);

        return view('orders.tracking', compact('order', 'trackingData'));
    }

    /**
     * Fetch tracking data from Binderbyte API.
     *
     * @param string      $trackingNumber  Nomor AWB / resi pengiriman
     * @param string|null $courier         Kode kurir yang disimpan admin (jne, jnt, sicepat, dll)
     */
    protected function fetchTrackingData(string $trackingNumber, ?string $courier = null)
    {
        $apiKey = config('services.binderbyte.api_key');

        // Gunakan kurir dari database jika tersedia, fallback ke auto-detect
        if (empty($courier)) {
            $courier = $this->detectCourier($trackingNumber);
        }

        if (!$apiKey) {
            return [
                'status'       => 'error',
                'message'      => 'Fitur pelacakan resi belum dikonfigurasi di server (API Key kosong).',
                'courier'      => strtoupper($courier),
                'service'      => 'Regular Service',
                'status_paket' => 'CONFIG ERROR',
                'history'      => []
            ];
        }

        try {
            $response = Http::timeout(10)->get("https://api.binderbyte.com/v1/track", [
                'api_key' => $apiKey,
                'courier' => $courier,
                'awb'     => $trackingNumber
            ]);

            if ($response->successful()) {
                $resJson = $response->json();
                if (isset($resJson['status']) && $resJson['status'] == 200) {
                    $data = $resJson['data'];
                    return [
                        'status'       => 'success',
                        'courier'      => strtoupper($data['summary']['courier'] ?? $courier),
                        'service'      => $data['summary']['service'] ?? 'Regular',
                        'status_paket' => $data['summary']['status'] ?? 'ON PROCESS',
                        'history'      => collect($data['history'] ?? [])->map(function ($item) {
                            return [
                                'date'     => $item['date'] ?? '',
                                'desc'     => $item['desc'] ?? '',
                                'location' => $item['location'] ?? ''
                            ];
                        })->toArray()
                    ];
                }

                // API Key benar, tetapi Binderbyte mengembalikan error (misal resi tidak terdaftar / fiktif)
                return [
                    'status'       => 'invalid_awb',
                    'message'      => $resJson['message'] ?? 'Nomor resi tidak sesuai atau tidak terdaftar di sistem ekspedisi.',
                    'courier'      => strtoupper($courier),
                    'service'      => 'Regular Service',
                    'status_paket' => 'RESI TIDAK SESUAI',
                    'history'      => []
                ];
            }
        } catch (\Exception $e) {
            // Koneksi bermasalah
            \Illuminate\Support\Facades\Log::error('Tracking API error: ' . $e->getMessage());
        }

        return [
            'status'       => 'error',
            'message'      => 'Gagal menghubungi server pelacakan ekspedisi. Silakan coba beberapa saat lagi.',
            'courier'      => strtoupper($courier),
            'service'      => 'Regular Service',
            'status_paket' => 'KONEKSI ERROR',
            'history'      => []
        ];
    }

    /**
     * Auto-detect courier berdasarkan pola nomor resi (fallback jika admin tidak memilih kurir).
     * Ini hanya perkiraan kasar — sebaiknya admin selalu memilih kurir secara eksplisit.
     */
    protected function detectCourier(string $trackingNumber): string
    {
        $tn = strtoupper(trim($trackingNumber));

        // J&T Express: biasanya diawali JP, JX, JA, 820, 822
        if (preg_match('/^(JP|JX|JA|82[02])/', $tn)) {
            return 'jnt';
        }

        // SiCepat: biasanya diawali 000, 001, 002, 003, 004
        if (preg_match('/^00[0-4]/', $tn)) {
            return 'sicepat';
        }

        // Pos Indonesia: biasanya diawali dengan huruf dan berakhir ID
        if (preg_match('/^[A-Z]{2}\d+ID$/i', $tn)) {
            return 'pos';
        }

        // Anteraja: biawali 1
        if (preg_match('/^1\d{11,}$/', $tn)) {
            return 'anteraja';
        }

        // Default: JNE (kurir paling umum di Indonesia)
        return 'jne';
    }
}
