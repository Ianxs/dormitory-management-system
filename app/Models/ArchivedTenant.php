<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedTenant extends Model
{
    protected $fillable = [
        'original_tenant_id',
        'room_number',
        'name',
        'email',
        'phone',
        'archived_at',
        'reason',
    ];
}
