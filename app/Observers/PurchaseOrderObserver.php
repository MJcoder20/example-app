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

        $quantity = DB::table('items')
        ->join('vendor_items', 'items.id', '=', 'vendor_items.item_id')
        ->where('vendor_items.item_id', '=', $order->item_id)
        ->where('vendor_items.quantity', '=', DB::raw('(select max(quantity) from inventory_items)'))
        ->value('quantity');

        //update inventory quantity according to amount of items purchased
        DB::table('items')
        ->join('inventory_items', 'items.id', '=', 'inventory_items.item_id')
        ->where('items.id', '=', $order->item_id)
        ->join('inventories', 'inventory_items.inventory_id', '=', 'inventories.id')
        ->where('inventory_items.quantity', '=', DB::raw('(select max(quantity) from inventory_items)'))
        ->update([
            'inventory_items.quantity' => $quantity - $cart[$order->item_id]['quantity']
        ]);

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
