<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorFilter extends Model
{

    public function filter(Builder $builder, $request){
        
        if(collect($request)->get('email')){
            $builder = $builder->where('email',collect($request)->get('email'));
        }
        if (collect($request)->get('first_name')){
            $builder = $builder->where('first_name', collect($request)->get('first_name'));
        }
        if (collect($request)->get('last_name')){
            $builder = $builder->where('last_name', collect($request)->get('last_name'));
        }
        if (collect($request)->get('is_active')){
            $builder = $builder->where('is_active', collect($request)->get('is_active'));
        }
        if (collect($request)->get('phone')){
            $builder = $builder->where('phone', collect($request)->get('phone'));
        }
        

        return $builder->get();

    }

    
}
