<?php

namespace App\Models;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManageUsers extends Authenticatable
{ 
    // use HasFactory;

    public $timestamps = true;
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';

    protected $fillable = ['username','first_name','last_name','email','password','is_admin','is_active'];
    protected $attributes = [
        'is_admin' => 0,
        'is_active' => 1,
    ];

    protected $hidden = [
        'password',
        'confirm_password',
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function scopeFilter(Builder $builder, $request){
        return (new UserFilter())->filter($builder, $request);
    }
   
    
    
    
}
