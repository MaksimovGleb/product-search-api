<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                Product::create([
                    'category_id' => $category->id,
                    'name'        => $category->name . ' Модель ' . $i,
                    'price'       => rand(5000, 100000) / 100,
                    'in_stock'    => (bool)rand(0, 1),
                    'rating'      => rand(10, 50) / 10,
                ]);
            }
        }
    }

}
