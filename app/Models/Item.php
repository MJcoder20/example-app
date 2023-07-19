<?php

namespace App\Models;

use App\Models\Filters\ItemFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable=['name','image','brand_id','is_active'];
    public $timestamps=true;

    public function brand(){
        $this->belongTo('App\Models\Brand');
    }

    public function scopeFilter(Builder $query,$request){
        return (new ItemFilter())->filter($query,$request);
    }
}
