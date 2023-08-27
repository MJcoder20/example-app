<?php

namespace App\Modules\User\App\Models;

use App\Models\Address;
use Laravel\Scout\Searchable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Database\Factories\UserFactory;
use App\Modules\User\App\Models\Filters\UserFilter;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use Searchable;

    protected $fillable = ['username','first_name','last_name','email',
    'password','is_admin','is_active','api_token'];

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

    

    public function getUser($id)
    {
        return User::find($id);
    }

    public function createUser(array $data)
    {
        $user = User::create($data);
        return $user;
    }


    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function items(): BelongsToMany{
        return $this->belongsToMany('App\Models\Item','App\Models\PurchaseOrder','user_id','item_id')
        ->withPivot('inventory_id','status')->withTimestamps();
    }


    //Accessors and Mutators
    public function userAddresses(){
        return Address::where('addressable_type','App\Modules\User\App\Models\User')
                ->where('addressable_id',$this->id)->get();
    }

    public function setAddresses($value){
        $this->attributes['addresses'] = $value;
    
    }

    public function getAddresses()
    {
       return $this->addresses;
    }

    public function setFullName($first,$last){
        $this->attributes['full_name']=$first. ' '.$last;
    }

    public function getFullName(){
        return $this->full_name;
    }


    protected static function newFactory()
    {
        return UserFactory::new();
    }


    //Filter
    public function scopeFilter(Builder $builder, $request){
        return (new UserFilter())->filter($builder, $request);
    }
}


?>