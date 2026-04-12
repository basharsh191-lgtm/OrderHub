<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories=
        [
        ['name'=>'Fast Food','image_url'=>'http://127.0.0.1:8000/storage/category/chicken_1.jpg'],
        ['name'=>'Italian','image_url'=>'http://127.0.0.1:8000/storage/category/pizza_1.jpg'],
        ['name'=>'Cafe','image_url'=>'http://127.0.0.1:8000/storage/category/coffee_1.jpg'],
        ['name'=>'Healthy','image_url'=>'http://127.0.0.1:8000/storage/category/healthy.jpg'],
        ['name'=>'Breakfast','image_url'=>'http://127.0.0.1:8000/storage/category/healthy.jpg'],
        ];
        foreach($categories as $category)
            {
                Category::create($category);
            }
    }
}
