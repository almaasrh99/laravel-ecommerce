<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Category::all();

        // Pastikan kategori tersedia sebelum membuat produk
        if ($categories->count() === 0) {
            $this->command->info('No categories found. Run CategorySeeder first.');
            return;
        }

        foreach (range(1, 30) as $i) {
            Product::create([
                'name' => $faker->words(3, true),
                'slug' => $faker->slug,
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(10000, 1000000),
                'image' => 'https://cdn.pixabay.com/photo/2021/06/04/06/09/cherries-6308871_1280.jpg',
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}


