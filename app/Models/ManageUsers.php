<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManageUsers extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['username','first_name','last_name','email','password','is_admin','is_active'];
    protected $attributes = [
        'is_admin' => 0,
        'is_active' => 1,
    ];

    protected $hidden = [
        'password',
        'confirm_password',
    ];

    
}
