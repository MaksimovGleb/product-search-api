<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_products_with_pagination(): void
    {
        Category::factory()->hasProducts(20)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure([
                'data',
                'links',
                'current_page',
                'last_page',
                'total'
            ]);
    }

    public function test_can_filter_products_by_name(): void
    {
        Category::factory()
            ->has(Product::factory()->count(1)->state(['name' => 'Unique Phone']))
            ->has(Product::factory()->count(1)->state(['name' => 'Simple Bread']))
            ->create();

        $response = $this->getJson('/api/products?q=Phone');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Unique Phone');
    }

    public function test_can_filter_products_by_price_range(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id, 'price' => 50]);
        Product::factory()->create(['category_id' => $category->id, 'price' => 150]);
        Product::factory()->create(['category_id' => $category->id, 'price' => 250]);

        $response = $this->getJson('/api/products?price_from=100&price_to=200');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            // Используем assertEquals для гибкого сравнения чисел
            ->assertJsonPath('data.0.price', "150.00");
    }

    public function test_can_sort_products_by_rating_desc(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id, 'rating' => 1.0]);
        Product::factory()->create(['category_id' => $category->id, 'rating' => 5.0]);

        $response = $this->getJson('/api/products?sort=rating_desc');

        $response->assertStatus(200);

        $this->assertEquals(5.0, $response->json('data.0.rating'));
    }

    public function test_can_filter_by_stock_status(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id, 'in_stock' => true]);
        Product::factory()->create(['category_id' => $category->id, 'in_stock' => false]);

        $response = $this->getJson('/api/products?in_stock=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.in_stock', true);
    }
}



