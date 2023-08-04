<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\Session;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

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
        $item = Item::find($purchaseOrder->item_id);
        $session = DB::table('sessions')->where('item',$item->name)->first();

        if(collect($session)->get('quantity')){

            $inven_items = DB::table('inventory_items')
            ->where('item_id', '=', $item->id)
            ->orderByDesc('quantity')
            ->first();

            $qty = collect($inven_items)->get('quantity') - collect($session)->get('quantity');

            //update inventory quantity according to amount of items purchased
            DB::table('inventory_items')
            ->where('inventory_items.inventory_id', '=', collect($inven_items)->get('inventory_id'))
            ->update([
                'quantity' => $qty
            ]);

            $pitem = DB::table('items')->where('items.id', '=',  $purchaseOrder->item_id)->get();
            $total_purchases = collect($pitem)->get('total_purchases') + collect($session)->get('quantity');

            DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)
            ->update([
                'total_purchases'=> $total_purchases
            ]);

            $newpitem = DB::table('items')
            ->where('items.id', '=', $purchaseOrder->item_id)->get();
            $total_sales = $total_purchases * collect($newpitem)->get('price');

            DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)
            ->update([
                'total_sales'=> $total_sales
            ]);

        }

        

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
