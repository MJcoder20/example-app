<?php

namespace App\Modules\User\App\Models\Filters;


use Illuminate\Support\Facades\DB;


class UserFilter {

    public function filter($query, $request){
        if (collect($request)->get('username')){
            $query->where('username','like', '%'.collect($request)->get('username').'%');
        }
        if (collect($request)->get('name')){
            $query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', collect($request)->get('name'));
        }
        if (collect($request)->get('is_active')!=null){
            $query->where('is_active', '=', collect($request)->get('is_active'));
        }
        if (collect($request)->get('is_admin')!=null){
            $query->where('is_admin', '=', collect($request)->get('is_admin'));
        }
        if(collect($request)->get('email')){
            $query->where('email', 'like', '%'.collect($request)->get('email').'%');
        }

        return $query;
    }
    
}


?>