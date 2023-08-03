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

    public function items(): BelongsToMany{
        return $this->belongsToMany('App\Models\Item','App\Models\InventoryItem')
        ->withTimestamps();
    }

    // public function purchase_items(): BelongsToMany{
    //     return $this->belongsToMany('App\Models\Item','App\Models\PurchaseOrder','inventory_id','item_id')
    //     ->withTimestamps();
    // }

    public function users(): BelongsToMany{
        return $this->belongsToMany('App\Models\ManageUsers','App\Models\PurchaseOrder','inventory_id','user_id')
        ->withPivot('item_id');
    }


    public function scopeFilter(Builder $query,$request){
        return (new InventoryFilter())->filter($query,$request);
    }
}
