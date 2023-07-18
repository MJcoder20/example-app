<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'addressable_id'=>Vendor::all()->random,
            // 'addressable_id'=>rand(1,5),
            'addressable_type'=>fake()->randomElement(['user','vendor']),
            'city_id'=>City::factory(),
            'district'=>fake()->address(),
            'street'=>fake()->streetAddress(),
            'phone'=>fake()->unique()->phoneNumber(),
        ];
    }
}
