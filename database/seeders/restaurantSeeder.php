<?php

namespace Database\Seeders;

use App\Models\restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class restaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        restaurant::create([
            'owner_id'=>1,
            'name'=>'Anas Shawrma',
            'slug'=>'anas-shawrma',
            'logo'=>'http://127.0.0.1:8000/storage/restaurantSeed/3.png',
            'cover_image'=>null,
            'description'=>'the best chicken in damascus',
            'phone'=>'0969227248',
            'address'=>'medan',
            'latitude'=>null,
            'longitude'=>null,
            'is_active'=>true,
            'opens_at'=>'10:00:00',
            'closes_at'=>'22:00:00',
        ]);
            restaurant::create([
            'owner_id'=>2,
            'name'=>'alzawak',
            'slug'=>'al-zawak',
            'logo'=>'http://127.0.0.1:8000/storage/restaurantSeed/2.png',
            'cover_image'=>null,
            'description'=>'the best chicken in damascus',
            'phone'=>'0969227249',
            'address'=>'medan',
            'latitude'=>null,
            'longitude'=>null,
            'is_active'=>true,
            'opens_at'=>'10:00:00',
            'closes_at'=>'22:00:00',
        ]);
            restaurant::create([
            'owner_id'=>1,
            'name'=>'Anas Shawrma 2',
            'slug'=>'anas-shawrma-2',
            'logo'=>'http://127.0.0.1:8000/storage/restaurantSeed/3.png',
            'cover_image'=>null,
            'description'=>'the best chicken in damascus',
            'phone'=>'0969227248',
            'address'=>'medan',
            'latitude'=>null,
            'longitude'=>null,
            'is_active'=>true,
            'opens_at'=>'10:00:00',
            'closes_at'=>'22:00:00',
        ]);
                restaurant::create([
            'owner_id'=>3,
            'name'=>'ala kefk',
            'slug'=>'ala-kefk',
            'logo'=>'http://127.0.0.1:8000/storage/restaurantSeed/2.png',
            'cover_image'=>null,
            'description'=>'the best chicken in damascus',
            'phone'=>'0969227245',
            'address'=>'medan',
            'latitude'=>null,
            'longitude'=>null,
            'is_active'=>true,
            'opens_at'=>'10:00:00',
            'closes_at'=>'22:00:00',
        ]);
    }
}
