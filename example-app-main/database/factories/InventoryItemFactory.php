<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = InventoryItem::class;

    public function definition()
    {
        $inventoryIDs = Inventory::all()->pluck('id');
        $itemIDs = Item::all()->pluck('id');

        return [
            'inventory_id'=>fake()->randomElement($inventoryIDs),
            'item_id' => fake()->randomElement($itemIDs),
            'quantity' => random_int(10, 150)
        ];
    }
}
