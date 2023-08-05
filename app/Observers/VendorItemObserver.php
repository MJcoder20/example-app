<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\VendorItem;
use Illuminate\Support\Facades\DB;
use App\Notifications\ItemAvailable;
use Illuminate\Support\Facades\Notification;

class VendorItemObserver
{
    /**
     * Handle the VendorItem "created" event.
     *
     * @param  \App\Models\VendorItem  $vendorItem
     * @return void
     */
    public function created(VendorItem $vendorItem)
    {
        //
    }

    /**
     * Handle the VendorItem "updated" event.
     *
     * @param  \App\Models\VendorItem  $vendorItem
     * @return void
     */
    public function updated(VendorItem $vendorItem)
    {
        DB::table('inventory_items')
        ->where('item_id','=',$vendorItem->item_id)
        ->update([
            'quantity' => $vendorItem->quantity
        ]);

        $item = Item::find($vendorItem->item_id);
        $item->available=1;
        $item->save();

        $users = DB::table('manage_users')->value('email')->get();

        Notification::send($users, new ItemAvailable($item));

    }

    /**
     * Handle the VendorItem "deleted" event.
     *
     * @param  \App\Models\VendorItem  $vendorItem
     * @return void
     */
    public function deleted(VendorItem $vendorItem)
    {
        //
    }

    /**
     * Handle the VendorItem "restored" event.
     *
     * @param  \App\Models\VendorItem  $vendorItem
     * @return void
     */
    public function restored(VendorItem $vendorItem)
    {
        //
    }

    /**
     * Handle the VendorItem "force deleted" event.
     *
     * @param  \App\Models\VendorItem  $vendorItem
     * @return void
     */
    public function forceDeleted(VendorItem $vendorItem)
    {
        //
    }
}
