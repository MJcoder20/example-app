<?php

namespace Database\Factories;

use App\Models\Vendor;
use App\Models\Inventory;
use App\Models\VendorInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VendorInventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = VendorInventory::class;

    public function definition()
    {
        $vendorIDs = Vendor::all()->pluck('id');
        $inventoryIDs = Inventory::all()->pluck('id');

        return [
            'vendor_id'=>fake()->randomElement($vendorIDs),
            'inventory_id' => fake()->randomElement($inventoryIDs),
        ];
    }
}
