<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowItemQuantityNotification;

class CheckItemQuantity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
     
        $itemQuantity = DB::table('items')
        ->join('inventory_items','items.id','=','inventory_items.item_id')
        ->where('inventory_items.quantity','=','select quantity from inventory_items')->get();

        // $itemQuantity = $request->;
        
        
        $inventories = Inventory::all();
        
        foreach ($inventories as $inventory) {
            if ($inventory->quantity >= 50) {
                return $next($request);
            }
        }

        // If item quantity is less than 50 in all inventories, send an email to the vendor
        Mail::to('vendor@example.com')->
        send(new LowItemQuantityNotification($itemQuantity));

        return $next($request);
    }
}
