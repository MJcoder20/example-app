<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        $this->call(
            [
                ManageUsersSeeder::class,
                VendorSeeder::class,
                CountrySeeder::class,
                CitySeeder::class,
                AddressSeeder::class,
                BrandSeeder::class,
                InventorySeeder::class,
                ItemSeeder::class,
                VendorItemSeeder::class,
                InventoryItemSeeder::class,
            ]);
    }
}
