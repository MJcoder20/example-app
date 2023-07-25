<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cityIDs = City::all()->pluck('id');

        return [
            'name'=>fake()->unique()->name(),
            'city_id'=>fake()->randomElement($cityIDs),
            'phone'=>fake()->unique()->phoneNumber(),
            
        ];
    }
}
