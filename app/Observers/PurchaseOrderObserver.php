<?php

namespace App\Observers;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PurchaseOrderObserver
{

    public function created(PurchaseOrder $order)
    {
        $cart = Session::get('cart');

        $purchases = DB::table('items')->where('items.id', '=',  $order->item_id)->select('items.total_purchases')->get();
        $price = DB::table('items')->where('items.id', '=', $order->item_id)->select('items.price')->get();

        DB::table('items')->where('items.id', '=', $order->item_id)
        ->update([
            'items.total_purchases'=>$purchases+$cart[$order->item_id]['quantity']
        ]);

        $newPurchases = DB::table('items')->where('items.id', '=', $order->item_id)->select('items.total_purchases')->get();

        DB::table('items')->where('items.id', '=', $order->item_id)
        ->update([
            'items.total_sales'=>$newPurchases*$price
        ]);

    }
    
    public function updated(PurchaseOrder $order)
    {
        
    }

}
