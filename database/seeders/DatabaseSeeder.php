<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $shari = Product::create([
            "title" => "Shari",
            "slug" => "shari",
            "category_id" => 1,
            "desc" => "Test Description",
            "small_desc" => "Test Small Description",
            "price" => 120,
            "quantity" => 100,
            "alert_quantity" => 10,
        ]);
        $shari->addMedia(storage_path('seed-images/shari_hero_image.webp'))
                ->preservingOriginal()
                ->toMediaCollection('hero_image');
        $shari->addMedia(storage_path('seed-images/shari_secondary_image.webp'))
                ->preservingOriginal()
                ->toMediaCollection('secondary_image');
        $shari->addMedia(storage_path('seed-images/shari_multiple_1.webp'))
                ->preservingOriginal()
                ->toMediaCollection('images');

        $shirt = Product::create([
            "title" => "Shirt",
            "slug" => "shirt",
            "category_id" => 1,
            "desc" => "Test Description",
            "small_desc" => "Test Small Description",
            "price" => 130,
            "quantity" => 110,
            "alert_quantity" => 12,
        ]);
        $shirt->addMedia(storage_path('seed-images/shirt_hero_image.webp'))
                ->preservingOriginal()
                ->toMediaCollection('hero_image');
        $shirt->addMedia(storage_path('seed-images/shirt_secondary_image.webp'))
                ->preservingOriginal()
                ->toMediaCollection('secondary_image');
                
        $panjabi = Product::create([
            "title" => "Panjabi",
            "slug" => "panjabi",
            "category_id" => 1,
            "desc" => "Test Description",
            "small_desc" => "Test Small Description",
            "price" => 130,
            "quantity" => 110,
            "alert_quantity" => 12,
        ]);
        $panjabi->addMedia(storage_path('seed-images/panjabi_hero_image.webp'))
                ->preservingOriginal()
                ->toMediaCollection('hero_image');
        $panjabi->addMedia(storage_path('seed-images/panjabi_secondary_image.webp'))
                ->preservingOriginal()
                ->toMediaCollection('secondary_image');
    }
}
