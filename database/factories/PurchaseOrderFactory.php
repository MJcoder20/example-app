<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use App\Models\Inventory;
use App\Models\ManageUsers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>User::factory(),
            'item_id'=>Item::factory(),
            'inventory_id'=>Inventory::factory(),
        ];
    }
}
