<?php

namespace App\Observers;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseObserver
{
    /**
     * Handle the PurchaseOrder "created" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function created(PurchaseOrder $purchaseOrder)
    {
        $cart = Session::get('cart');

        $quantity = DB::table('items')
        ->join('vendor_items', 'items.id', '=', 'vendor_items.item_id')
        ->where('vendor_items.item_id', '=', $purchaseOrder->item_id)
        ->where('vendor_items.quantity', '=', DB::raw('(select max(quantity) from inventory_items)'))
        ->value('quantity');

        //update inventory quantity according to amount of items purchased
        DB::table('items')
        ->join('inventory_items', 'items.id', '=', 'inventory_items.item_id')
        ->where('items.id', '=', $purchaseOrder->item_id)
        ->join('inventories', 'inventory_items.inventory_id', '=', 'inventories.id')
        // ->where('inventory_items.quantity', '=', DB::raw('(select max(quantity) from inventory_items)'))
        ->update([
            'inventory_items.quantity' => $quantity - $cart[$purchaseOrder->item_id]['quantity']
        ]);

        $purchases = DB::table('items')->where('items.id', '=',  $purchaseOrder->item_id)->select('items.total_purchases')->get();
        $price = DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)->select('items.price')->get();

        DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)
        ->update([
            'items.total_purchases'=>$purchases+$cart[$purchaseOrder->item_id]['quantity']
        ]);

        $newPurchases = DB::table('items')
        ->where('items.id', '=', $purchaseOrder->item_id)->select('items.total_purchases')->get();

        DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)
        ->update([
            'items.total_sales'=>$newPurchases*$price
        ]);
    }

    /**
     * Handle the PurchaseOrder "updated" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function updated(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the PurchaseOrder "deleted" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function deleted(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the PurchaseOrder "restored" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function restored(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the PurchaseOrder "force deleted" event.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function forceDeleted(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
