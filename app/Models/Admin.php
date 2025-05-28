<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'admin_id', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
