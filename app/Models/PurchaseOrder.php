<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Pivot
{
    use HasFactory;

    public $table = 'purchase_orders';
    protected $fillable = ['user_id','item_id','inventory_id','status'];
    protected $attributes = [
        'status' => 0,
    ];
    public $timestamps=true;

    protected static function booted()
    {
        static::creating(function (PurchaseOrder $purchaseOrder) {
            $item = Item::find($purchaseOrder->item_id);
            $session = Session::find($item->name);
    
            if($session){
    
                $quantity = DB::table('vendor_items')
                ->where('vendor_items.item_id', '=', $purchaseOrder->item_id)
                ->where('vendor_items.quantity', '=', DB::raw('(select max(quantity) from inventory_items)'))
                ->value('quantity')->first();
    
                //update inventory quantity according to amount of items purchased
                DB::table('inventory_items')
                ->where('inventory_items.item_id', '=', $purchaseOrder->item_id)
                ->join('inventories', 'inventory_items.inventory_id', '=', 'inventories.id')
                ->where('inventory_items.quantity', '=', DB::raw('(select max(quantity) from inventory_items)'))
                ->update([
                    'inventory_items.quantity' => $quantity - $session->quantity
                ]);
    
                $purchases = DB::table('items')->where('items.id', '=',  $purchaseOrder->item_id)->select('items.total_purchases')->get();
                $price = DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)->select('items.price')->get();
    
                DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)
                ->update([
                    'items.total_purchases'=>$purchases+$session->quantity
                ]);
    
                $newPurchases = DB::table('items')
                ->where('items.id', '=', $purchaseOrder->item_id)->select('items.total_purchases')->get();
    
                DB::table('items')->where('items.id', '=', $purchaseOrder->item_id)
                ->update([
                    'items.total_sales'=>$newPurchases*$price
                ]);
    
            }
    
            
        });
    }

}
