<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Product::create([
            'restaurant_id'=>1,
            'name'=>'garlic dip',
            'description'=>'Toum',
            'price'=>'100',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>1,
            'name'=>'broasted',
            'description'=>'chicken',
            'price'=>'900',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>1,
            'name'=>'sandwich',
            'description'=>null,
            'price'=>'250',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>1,
            'name'=>'Kola',
            'description'=>null,
            'price'=>'100',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>1,
            'name'=>'french fries',
            'description'=>null,
            'price'=>'130',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>2,
            'name'=>'garlic dip',
            'description'=>'Toum',
            'price'=>'100',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>2,
            'name'=>'broasted',
            'description'=>'chicken',
            'price'=>'900',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>2,
            'name'=>'sandwich',
            'description'=>null,
            'price'=>'250',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>2,
            'name'=>'Kola',
            'description'=>null,
            'price'=>'100',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>2,
            'name'=>'french fries',
            'description'=>null,
            'price'=>'130',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>3,
            'name'=>'garlic dip',
            'description'=>'Toum',
            'price'=>'100',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>3,
            'name'=>'broasted',
            'description'=>'chicken',
            'price'=>'900',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>3,
            'name'=>'sandwich',
            'description'=>null,
            'price'=>'250',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>3,
            'name'=>'Kola',
            'description'=>null,
            'price'=>'100',
            'image'=>null,
            'is_available'=>true,
        ]);
            Product::create([
            'restaurant_id'=>3,
            'name'=>'french fries',
            'description'=>null,
            'price'=>'130',
            'image'=>null,
            'is_available'=>true,
        ]);
    }
}
