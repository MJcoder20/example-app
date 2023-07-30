<?php

namespace App\Models;

use App\Models\Filters\ItemFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable=['name','image','brand_id','is_active','available',
    'price','total_purchases','total_sales'];

    protected $attributes =[
        'is_active'=>1,
        'available'=>1
    ];

    public $timestamps=true;
    

    public function brand(): BelongsTo{
        return $this->belongsTo('App\Models\Brand');
    }

    public function inventories(): BelongsToMany{
        return $this->belongsToMany('App\Models\Inventory')->withTimestamps();;
    }

    public function vendors(): BelongsToMany{
        return $this->belongsToMany('App\Models\Vendor')->withTimestamps();;
    }

    public function purchase_orders(){
        return $this->hasMany(PurchaseOrder::class);
    }

    // public function isInventoryItemsLessThan50(Builder $query)
    // {
    //     $query
    //         ->join('inventory_items','items.id','=','inventory_items.item_id')
    //         ->join('inventories','inventory_items.inventory_id','=','inventories.id')
    //         ->select('items.*','inventories.*')
    //         ->where('inventory_items.quantity','<','50')->get();
    //     if(!$query){
    //         return true;
    //     }
    //     return false;
    // }

    public function scopeFilter(Builder $query,$request){
        return (new ItemFilter())->filter($query,$request);
    }
}
