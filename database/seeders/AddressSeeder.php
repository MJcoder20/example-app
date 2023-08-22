<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\ManageUsers;
use Illuminate\Database\Seeder;
use App\Modules\User\App\Models\User;
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
        Address::factory()->count(1)->for(User::factory(),'addressable')
        ->for(Vendor::factory(),'addressable')
        ->for(City::factory()->create())
        ->create();
    }
}
