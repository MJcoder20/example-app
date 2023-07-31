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
        // if(request('pricefilter')){
        //     $price=request('pricefilter');
        //     if($price=='0,25'){
        //         
        //         $query->whereBetween('price',[1, 24]);
        //     }
        //     // $query->where('items.price','=',collect($request)->get('price'));
        // }
        if(collect($request)->get('total_purchases')!=null){
            $query->where('items.total_purchases','=',collect($request)->get('total_purchases'));
        }
        if(collect($request)->get('total_sales')!=null){
            $query->where('items.total_sales','=',collect($request)->get('total_sales'));
        }

        if(collect($request)->get('brand')){
            $brands = collect($request)->get('brand');
            foreach ($brands as $brand) {
                $query->where('items.brand_id','=',$brand);
            }
        }
        if(collect($request)->get('vendor')){
            $vendors = collect($request)->get('vendor');
            $query
            ->join('vendor_items','items.id','=','vendor_items.item_id')
            ->join('vendors','vendor_items.vendor_id','=','vendors.id')
            ->select('items.*','vendor_items.*');
            foreach ($vendors as $vendor) {
                $query->where('vendor_items.vendor_id','=',$vendor);
            }
        }
        if(collect($request)->get('inventory')){
            $inventories = collect($request)->get('inventory');
            $query
                ->join('inventory_items','items.id','=','inventory_items.item_id')
                ->join('inventories','inventory_items.inventory_id','=','inventories.id')
                ->select('items.*','inventory_items.*');
            foreach($inventories as $inventory) {
                $query->where('inventory_items.inventory_id','=',$inventory);
        
            }
        }
        if(collect($request)->get('qty')){
         
            $query
            ->join('inventory_items','items.id','=','inventory_items.item_id')
            ->join('inventories','inventory_items.inventory_id','=','inventories.id')
            ->select('items.*','inventories.*')
            ->where('inventory_items.quantity','>','50');
        }
     
        // if(collect($request)->get('id')!=null){
        //     $query
        //     ->join('inventory_items','items.id','=','inventory_items.item_id')
        //     ->join('inventories','inventory_items.inventory_id','=','inventories.id')
        //     ->select('items.*','inventories.*')
        //     ->where('items.id','>','50');
        // }
        

        return $query;

    }
}
