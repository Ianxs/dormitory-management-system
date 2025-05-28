<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'tenant_id',
        'payment_date',
        'amount',
        'due_amount',
        'status'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
    ];

    /**
     * Get the tenant that owns the payment.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
