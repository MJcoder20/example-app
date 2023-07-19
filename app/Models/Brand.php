<?php

namespace App\Models;

use App\Models\Filters\BrandFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name','notes','icon'];
    public $timestamps=true;

    public function items(){
        $this->hasMany('App\Models\Item');
    }

    public function scopeFilter(Builder $query, $request){
        return (new BrandFilter())->filter($query,$request);
    }

}
