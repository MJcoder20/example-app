<?php

namespace App\Models\Filters;

use Illuminate\Support\Facades\DB;
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
        if (collect($request)->get('is_active')!=null){
            $query->where('is_active', '=', collect($request)->get('is_active'));
        }
        if(collect($request)->get('price')!=null){
            $query->where('items.price','=',collect($request)->get('price'));
        }
        if(collect($request)->get('total_purchases')!=null){
            $query->where('items.total_purchases','=',collect($request)->get('total_purchases'));
        }
        if(collect($request)->get('total_sales')!=null){
            $query->where('items.total_sales','=',collect($request)->get('total_sales'));
        }
        if(collect($request)->get('brand_id')!=null){
            $query->where('items.brand_id','=',collect($request)->get('brand_id'));
        }
        if(collect($request)->get('inventory_id')!=null){
            $query
            ->join('inventory_items','items.id','=','inventory_items.item_id')
            ->join('inventories','inventory_items.inventory_id','=','inventories.id')
            ->select('items.*','inventory_items.*')
            ->where('inventory_items.inventory_id','=',collect($request)->get('inventory_id'));
        }
        if(collect($request)->get('vendor_id')!=null){
            $query
            ->join('inventory_items','items.id','=','inventory_items.item_id')
            ->join('inventories','inventory_items.inventory_id','=','inventories.id')
            ->join('vendor_inventories','inventories.id','=','vendor_inventories.inventory_id')
            ->join('vendors','vendor_inventories.vendor_id','=','vendors.id')
            ->select('items.*','vendor_inventories.*')
            ->where('vendor_inventories.vendor_id','=',collect($request)->get('vendor_id'));
        }
        if(collect($request)->get('id')!=null){
            $query->
            join('inventory_items','items.id','=','inventory_items.item_id')
            ->join('inventories','inventory_items.inventory_id','=','inventories.id')
            ->select('items.*','inventories.*')
            ->where('items.id','>','50');
        }
        

        return $query;

    }
}
