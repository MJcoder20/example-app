<?php

namespace App\Models\Filters;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class InventoryFilter extends Model
{
    public function filter($query, $request){
        
        if(collect($request)->get('name')){
            $query->where('name', 'like', '%'.collect($request)->get('name').'%');
        }
        if(collect($request)->get('city_id')!=null){
            $query->where('city_id','=',collect($request)->get('city_id'));
        }   
        if (collect($request)->get('is_active')!=null){
            $query->where('is_active', '=', collect($request)->get('is_active'));
        }
        if (collect($request)->get('phone')){
            $query->where('phone', 'like',"%".collect($request)->get('phone')."%");
        }

        return $query;

    }

}
