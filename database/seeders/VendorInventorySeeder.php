<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\Inventory;
use App\Models\VendorInventory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorInventory::factory()->count(4)->create();
    }
}
