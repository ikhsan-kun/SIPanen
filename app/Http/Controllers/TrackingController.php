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

        $trackingData = $this->fetchTrackingData($order->tracking_number);

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

        $trackingData = $this->fetchTrackingData($order->tracking_number);

        return view('orders.tracking', compact('order', 'trackingData'));
    }

    /**
     * Fetch tracking data from Binderbyte API or fallback to beautiful mockup data
     */
    protected function fetchTrackingData($trackingNumber)
    {
        $apiKey = env('BINDERBYTE_API_KEY');
        
        // Deteksi kurir berdasarkan awalan resi secara sederhana (default jne)
        $courier = 'jne';
        $tnLower = strtolower($trackingNumber);
        if (str_contains($tnLower, 'jnt') || str_contains($tnLower, 'jp')) {
            $courier = 'jnt';
        } elseif (str_contains($tnLower, 'sicepat') || str_contains($tnLower, 'si')) {
            $courier = 'sicepat';
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
            $response = Http::get("https://api.binderbyte.com/v1/track", [
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
}
