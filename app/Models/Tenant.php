<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tenant extends Authenticatable
{
    use Notifiable;

    protected $guard = 'tenant';

    protected $fillable = [
        'tenant_id', 'tenant_password', 'tenant_name', 'tenant_contact', 'total_occupants',
        'subscriptions', 'room_number', 'lease_end', 'total_paid', 'due_amount', 'status'
    ];

    protected $hidden = [
        'tenant_password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_amount' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'total_occupants' => 'integer',
    ];

    /**
     * Get the payments for the tenant.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->tenant_password;
    }
}
