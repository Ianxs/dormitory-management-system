<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type',
        'capacity',
        'current_occupants',
        'is_available'
    ];

    /**
     * Get the tenants for the room.
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'room_number', 'room_number');
    }
}
