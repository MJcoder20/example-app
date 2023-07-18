<?php

namespace Database\Factories;

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
            'addressable_id'=>rand(1,5),
            'addressable_type'=>fake()->randomElement(['user','vendor']),
            'city_id'=>rand(1,5),
            'district'=>fake()->address(),
            'street'=>fake()->streetAddress(),
            'phone'=>fake()->unique()->phoneNumber(),
        ];
    }
}
