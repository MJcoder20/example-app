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
        'available'=>1,
        'total_purchases'=>0,
        'total_sales'=>0
    ];

    public $timestamps=true;
    

    public function brand(): BelongsTo{
        return $this->belongsTo('App\Models\Brand');
    }

    public function users(): BelongsToMany{
        return $this->belongsToMany('App\Models\ManageUsers','App\Models\PurchaseOrder','item_id','user_id')
        ->withTimestamps();
    }

    public function purchase_inventories(): BelongsToMany{
        return $this->belongsToMany('App\Models\Inventory','App\Models\PurchaseOrder','item_id','inventory_id')
        ->withTimestamps();;
    }

    public function inventories(): BelongsToMany{
        return $this->belongsToMany('App\Models\Inventory','App\Models\InventoryItem')->withTimestamps();;
    }

    public function vendors(): BelongsToMany{
        return $this->belongsToMany('App\Models\Vendor')->withTimestamps();;
    }


    public function scopeFilter(Builder $query,$request){
        return (new ItemFilter())->filter($query,$request);
    }
}
