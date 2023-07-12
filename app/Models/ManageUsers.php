<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUsers extends Model
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
