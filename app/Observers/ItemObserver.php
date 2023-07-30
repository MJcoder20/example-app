<?php

namespace App\Observers;

use Str;
use App\Models\Item;

class ItemObserver
{

    /**
     * Handle the Item "created" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function created(Item $item)
    {
        // $item->unique_id = 'IT-'.$item->id;
        // $item->save();
    }


    public function creating(Item $item){
        // $item->slug = Str::slug($item->name);
    }

    /**
     * Handle the Item "updated" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function updated(Item $item)
    {
        //
    }

    public function onEmailUpdating(Item $item, string $newValue, string $oldValue)
    {
      // Your logic goes here...
    }

    /**
     * Handle the Item "deleted" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function deleted(Item $item)
    {
        // $item->purchase_orders()->delete();
    }

    /**
     * Handle the Item "restored" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function restored(Item $item)
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     *
     * @param  \App\Models\Item  $item
     * @return void
     */
    public function forceDeleted(Item $item)
    {
        //
    }
}
