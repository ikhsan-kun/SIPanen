<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'subtotal', 'shipping_cost', 'total_amount',
        'status', 'payment_status', 'payment_method', 'midtrans_order_id',
        'midtrans_snap_token', 'midtrans_transaction_id',
        'recipient_name', 'recipient_phone', 'shipping_address',
        'shipping_city', 'shipping_province', 'shipping_postal_code',
        'notes', 'paid_at', 'shipped_at', 'completed_at',
    ];

    protected $casts = [
        'paid_at'      => 'datetime',
        'shipped_at'   => 'datetime',
        'completed_at' => 'datetime',
        'subtotal'     => 'decimal:2',
        'shipping_cost'=> 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'EKI-' . strtoupper(Str::random(8)) . '-' . now()->format('ymd');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentConfirmation()
    {
        return $this->hasOne(PaymentConfirmation::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu',
            'confirmed'  => 'Dikonfirmasi',
            'diproses'   => 'Diproses',
            'dikirim'    => 'Dikirim',
            'selesai'    => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'yellow',
            'confirmed'  => 'blue',
            'diproses'   => 'indigo',
            'dikirim'    => 'purple',
            'selesai'    => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid'               => 'Belum Bayar',
            'pending_confirmation' => 'Menunggu Konfirmasi',
            'paid'                 => 'Lunas',
            'failed'               => 'Gagal',
            default                => ucfirst($this->payment_status),
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}
