<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemFilter extends Model
{
    public function filter($query,$request){
       
        if (collect($request)->get('name')){
            $query->where('name', 'like', '%'.collect($request)->get('name').'%');
        }
        if (collect($request)->get('image')){
            $query->where('image', 'like', '%'.collect($request)->get('image').'%');
        }
        if(collect($request)->get('brand_id')!=null){
            $query->where('brand_id', '=', collect($request)->get('brand_id'));
        }
        if (collect($request)->get('is_active')!=null){
            $query->where('is_active', '=', collect($request)->get('is_active'));
        }
        

        return $query;

    }
}
