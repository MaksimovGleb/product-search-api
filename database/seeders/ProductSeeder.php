<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        Product::factory()
            ->count(50)
            ->create([
                'category_id' => fn() => $categories->random()->id,
            ]);
    }

}
