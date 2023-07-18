<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorFilter extends Model
{

    public function filter($query, $request){
        
        if(collect($request)->get('email')){
            $query->where('email', 'like', '%'.collect($request)->get('email').'%');
        }
        if (collect($request)->get('first_name') && collect($request)->get('last_name')){
            $query->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%'.collect($request)->get('first_name').' '.collect($request)->get('last_name').'%']);
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
