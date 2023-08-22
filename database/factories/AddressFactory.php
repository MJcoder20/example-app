<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\ManageUsers;
use App\Modules\User\App\Models\User;
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
        // $cityIDs = City::all()->pluck('id');

        return [
            'addressable_id'=>Vendor::factory()||User::factory(),
            'addressable_type'=>function (array $attributes) {
                return (class_basename(Vendor::find($attributes['addressable_id'])->type))||
                (class_basename(User::find($attributes['addressable_id'])->type));
            },
            'city_id'=>City::factory(),
            'district'=>fake()->address(),
            'street'=>fake()->streetAddress(),
            'phone'=>fake()->unique()->phoneNumber(),
        ];
    }
}
