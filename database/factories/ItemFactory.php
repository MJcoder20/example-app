<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $brand = Brand::inRandomOrder()->first();
        // $brand = Brand::all()->pluck('id');
        $brand instanceof Brand ? $brandId = $brand->id : $brandId = null;
        
        $name = fake()->name();
        
        // Generate unique brandId-name combination
        $brandIdAndName = fake()->unique()->regexify("/^$brandId-$name");
        $name = explode('-', $brandIdAndName)[1];


        return [
            'name'=>$name,
            'image'=>fake()->image('public/images', 640, 480, null, false),
            'brand_id'=>$brandId,
            // 'total_purchases'=> random_int(10, 50),
            // 'total_sales'=> random_int(100,500),
            'price' => random_int(10,80),
        ];
    }
}
