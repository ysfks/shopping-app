<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

class CollectCategoriesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_endpoint_returns_all_categories()
    {
        Category::factory()->create(['name' => "men's clothing"]);
        Category::factory()->create(['name' => 'jewelery']);
        Category::factory()->create(['name' => 'electronics']);
        Category::factory()->create(['name' => "women's clothing"]);

        $response = $this->getJson('/api/products/categories');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJsonFragment(['name' => "men's clothing"])
            ->assertJsonFragment(['name' => 'jewelery'])
            ->assertJsonFragment(['name' => 'electronics'])
            ->assertJsonFragment(['name' => "women's clothing"]);
    }
}

