<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // InventoryItem::factory()->count(4)->for(Inventory::factory()->create())
        // ->for(Item::factory()->create())->create();
        
        InventoryItem::factory()->count(4)->create();
    }
}
