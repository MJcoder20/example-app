<?php 

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class UserFilter {

    // public function scopeUsername(Builder $query, string $username)
    // {
    //     return $query->where('username', $username);
    // }

    // public function scopeName(Builder $query, string $name)
    // {
    //     $splitname = explode(" ", $name);
    //     $firstname = $splitname[0];
    //     $lastname = $splitname[1];
          
    //     return $query->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".$firstname." ".$lastname."%");
    // }

 

    public function filter(Builder $builder, $request){
        if (collect($request)->get('username')){
            $builder = $builder->where('username', collect($request)->get('username'));
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
        if (collect($request)->get('is_admin')){
            $builder = $builder->where('is_admin', collect($request)->get('is_admin'));
        }
        if(collect($request)->get('email')){
            $builder = $builder->where('email',collect($request)->get('email'));
        }

        return $builder->get();

    }
}