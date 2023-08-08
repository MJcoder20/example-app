<?php

namespace App\Models;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Filters\UserFilter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\ManageUsers as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ManageUsers extends Authenticatable 
{ 
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = true;

    protected $fillable = ['username','first_name','last_name','email','password','is_admin','is_active'];
    protected $attributes = [
        'is_admin' => 0,
        'is_active' => 1,
    ];

    protected $hidden = [
        'password',
        'confirm_password',
        'remember_token'
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function items(): BelongsToMany{
        return $this->belongsToMany('App\Models\Item','App\Models\PurchaseOrder','user_id','item_id')
        ->withPivot('inventory_id','status')->withTimestamps();
    }

    // public function inventories(): BelongsToMany{
    //     return $this->belongsToMany('App\Models\Inventory','App\Models\PurchaseOrder','user_id','inventory_id')
    //     ->withPivot('item_id','status')->withTimestamps();
    // }


    public function scopeFilter(Builder $builder, $request){
        return (new UserFilter())->filter($builder, $request);
    }
   
    
  
    // public function setRememberToken($token){
    //     $this->rememberTokenName = $token;
    // }
}
