<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Vendor;
use App\Models\Filters\InventoryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['name','city_id','phone','is_active'];
    
    protected $attributes = [
        'is_active'=>1,
    ];

    public $timestamps=true;


    public function city(): BelongsTo{
        return $this->belongsTo('App\Models\City');
    }

    public function vendors(): BelongsToMany{
        return $this->belongsToMany('App\Models\Vendor')->withTimestamps();;
    }

    public function items(): BelongsToMany{
        return $this->belongsToMany('App\Models\Item')->withTimestamps();;
    }

    public function scopeFilter(Builder $query,$request){
        return (new InventoryFilter())->filter($query,$request);
    }
}
