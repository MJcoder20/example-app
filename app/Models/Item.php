<?php

namespace App\Models;

use App\Models\Filters\ItemFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable=['name','image','brand_id','is_active'];

    protected $attributes =[
        'is_active'=>1
    ];

    public $timestamps=true;
    

    public function brand(): BelongsTo{
        return $this->belongsTo('App\Models\Brand');
    }

    public function inventories(): BelongsToMany{
        return $this->belongsToMany('App\Models\Inventory')->withTimestamps();;
    }

    public function scopeFilter(Builder $query,$request){
        return (new ItemFilter())->filter($query,$request);
    }
}
