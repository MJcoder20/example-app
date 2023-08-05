<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\Session;
use App\Models\Inventory;
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

                $quantity = collect($session)->get('quantity');
               
                $inven_items = DB::table('inventory_items')
                ->where('item_id', '=', $purchaseOrder->item_id)
                ->orderByDesc('quantity')
                ->first();
    
                   
                $qty = collect($inven_items)->get('quantity') - $quantity;
            
                // DB::table('inventory_items')
                // ->where('item_id','=',$item->item_id)
                // ->where('inventory_id', '=', $purchaseOrder->inventory_id)
                // ->decrement('quantity',$quantity);

                // update inventory quantity according to amount of items purchased
                // DB::table('inventory_items')
                // ->where('item_id','=',$item->item_id)
                // ->where('inventory_id', '=', $purchaseOrder->inventory_id)
                // ->update([
                //     'quantity' => $qty
                // ]);

                $inv = Inventory::find($purchaseOrder->inventory_id);
                $inv->items()->updateExistingPivot($item->id,['quantity'=>$qty]);
    
                $pitem = DB::table("items")->where('id','=', $purchaseOrder->item_id)->first();
                

                $total_purchases = collect($pitem)->get('total_purchases') + $quantity;
                // DB::table("items")
                // ->where('id', $item->item_id)
                // ->increment('total_purchases',$quantity);

                DB::table('items')->where('id', '=', $purchaseOrder->item_id)
                ->update([
                    'total_purchases'=> $total_purchases
                ]);
    
                $newpitem = DB::table('items')
                ->where('id', '=', $purchaseOrder->item_id)->first();
                $total_sales = $total_purchases * collect($newpitem)->get('price');
    

                DB::table("items")
                ->where('id','=',$purchaseOrder->item_id)
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
