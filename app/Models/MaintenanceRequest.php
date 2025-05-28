<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'room_number',
        'issue_type',
        'description',
        'image_path',
        'priority',
        'status',
        'tenant_name',
        'tenant_contact',
        'date',
    ];

    /**
     * Get the tenant that owns the maintenance request.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
