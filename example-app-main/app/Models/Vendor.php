<?php

namespace App\Models;

use App\Models\Filters\VendorFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vendor extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['email','first_name','last_name','is_active','phone'];

    protected $attributes = [
        'is_active' => 1,
    ];

    public $timestamps = true;


    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function inventories(): BelongsToMany{
        return $this->belongsToMany('App\Models\Inventory')->withTimestamps();;
    }
    
    public function items(): BelongsToMany{
        return $this->belongsToMany('App\Models\Item')->withTimestamps();;
    }

    public function scopeFilter(Builder $builder, $request){
        return (new VendorFilter())->filter($builder,$request);
    }

}
