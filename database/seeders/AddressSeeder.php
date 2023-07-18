<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\ManageUsers;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::factory()->count(4)->for(
            [ManageUsers::factory(),Vendor::factory()],'addressable'
        )->has(City::factory()->count(4))->create();
    }
}
