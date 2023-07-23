<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()->count(5)->for(Brand::factory()->create())->create();
    }
}
