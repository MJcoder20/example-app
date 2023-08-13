<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Filters\UserFilter;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   
    protected $fillable = ['username','first_name','last_name','email',
    'password','is_admin','is_active'];

    public $timestamps = true;

    protected $attributes = [
        'is_admin' => 0,
        'is_active' => 1,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'confirm_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function items(): BelongsToMany{
        return $this->belongsToMany('App\Models\Item','App\Models\PurchaseOrder','user_id','item_id')
        ->withPivot('inventory_id','status')->withTimestamps();
    }


    // public function createRefreshToken($name, array $scopes = [])
    // {
    //     return Container::getInstance()->make(PersonalAccessTokenFactory::class)->make(
    //         $this->getKey(), $name, $scopes
    //     );
    // }

    // public function AauthAcessToken(){
    //     return $this->hasMany('\App\OauthAccessToken');
    // }

    // public function refresh_tokens(): MorphMany
    // {
    //     return $this->morphMany('App\Models\RefreshToken', 'tokenable');
    // }


    public function scopeFilter(Builder $builder, $request){
        return (new UserFilter())->filter($builder, $request);
    }
}
