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

 

    public function filter($query, $request){
        if (collect($request)->get('username')){
            $query->where('username','like', '%'.collect($request)->get('username').'%');
        }
        
        // if (collect($request)->get('first_name') && collect($request)->get('last_name')){
        //     // $query->where("CONCAT(first_name, ' ', last_name)", ' LIKE ' ,"%".collect($request)->get('first_name').' '.collect($request)->get('last_name')."%");
        //     $query->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%'.collect($request)->get('first_name').' '.collect($request)->get('last_name').'%']);
        // }
        // if (collect($request)->get('first_name') && collect($request)->get('last_name')){
        //     $query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', collect($request)->get('first_name')." ".collect($request)->get('last_name'));
        // }
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