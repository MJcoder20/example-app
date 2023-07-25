<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Model;

class BrandFilter extends Model
{
   
    public function filter($query,$request){
       
        if (collect($request)->get('name')){
            $query->where('name', 'like', '%'.collect($request)->get('name').'%');
        }
        if(collect($request)->get('notes')){
            $query->where('notes', 'like', '%'.collect($request)->get('notes').'%');
        }
        if (collect($request)->get('icon')){
            $query->where('icon', 'like', '%'.collect($request)->get('icon').'%');
        }
        

        return $query;

    }
}
