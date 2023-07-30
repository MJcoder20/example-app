<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Vendor;
use App\Models\VendorItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VendorItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = VendorItem::class;

    public function definition()
    {
        $vendorIDs = Vendor::all()->pluck('id');
        $itemIDs = Item::all()->pluck('id');

        return [
            'vendor_id'=>fake()->randomElement($vendorIDs),
            'item_id' => fake()->randomElement($itemIDs),
            'quantity' => random_int(10, 50)
        ];
    }
}
