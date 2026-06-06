<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    protected $fillable = [
        'order_id', 'bank_name', 'account_name', 'account_number',
        'amount_paid', 'transfer_proof', 'transfer_date', 'status', 'admin_notes',
    ];

    protected $casts = [
        'amount_paid'   => 'decimal:2',
        'transfer_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
