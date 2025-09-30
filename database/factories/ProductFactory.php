<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'external_id' => $this->faker->unique()->numberBetween(1, 10000),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'price' => $this->faker->randomFloat(2, 1, 999),
            'category_id' => Category::factory(),
            'rating_rate' => $this->faker->optional()->randomFloat(1, 1, 5),
            'rating_count' => $this->faker->optional()->numberBetween(0, 1000),
        ];
    }
}

