<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_products_requires_authentication()
    {
        $response = $this->postJson('/api/products/import');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_import_products()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;
        $response = $this->postJson('/api/products/import', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(202)
            ->assertJson(['message' => 'Product import job dispatched.']);
    }

    public function test_authenticated_user_can_update_product()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;
        $category = Category::factory()->create(['name' => 'TestCat']);
        $product = Product::factory()->create(['category_id' => $category->getKey()]);
        $response = $this->putJson('/api/products/' . $product->getKey(), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'image' => 'http://example.com/image.jpg',
            'price' => 99.99,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);
    }

    public function test_update_product_requires_authentication()
    {
        $product = Product::factory()->create();
        $response = $this->putJson('/api/products/' . $product->getKey(), [
            'title' => 'Updated Title',
        ]);
        $response->assertStatus(401);
    }

    public function test_products_response_includes_category_object()
    {
        $category = Category::factory()->create(['name' => 'TestCat']);
        $product = Product::factory()->for($category)->create();
        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'TestCat']);
        $this->assertArrayHasKey('category', $response->json('data.0'));
        $this->assertEquals('TestCat', $response->json('data.0.category.name'));
    }

    public function test_products_can_be_filtered_by_category()
    {
        $cat1 = Category::factory()->create(['name' => 'Cat1']);
        $cat2 = Category::factory()->create(['name' => 'Cat2']);
        Product::factory()->for($cat1)->create(['title' => 'A']);
        Product::factory()->for($cat2)->create(['title' => 'B']);
        $response = $this->getJson('/api/products?category=' . $cat2->getKey());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Cat2']);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('B', $response->json('data.0.title'));
    }
}
