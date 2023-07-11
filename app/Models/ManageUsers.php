<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUsers extends Model
{
    use HasFactory;

    protected $attributes = [
        'is_admin' => 0,
        'is_active' => 1,
    ];

    
}
