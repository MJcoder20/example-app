<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::factory()->count(6)->has(Item::factory()->count(4))->create();
    }
}
