<?php
namespace App\Domains\Product\Jobs;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class ImportProductsJob
{
    public function handle(Logger $log): void
    {
        try {
            $response = Http::acceptJson()->get('https://fakestoreapi.com/products');
            if ($response->successful()) {

                $responseData = $response->json();
                $existingCategories = Category::all()->pluck('id', 'name')->toArray();

                $newCategoryNames = collect($responseData)
                    ->pluck('category')
                    ->unique()
                    ->diff(array_keys($existingCategories))
                    ->values();

                $insertData = $newCategoryNames->map(fn($name) => [
                    'name' => $name,
                    'updated_at' => now(),
                    'created_at' => now(),
                ])->all();

                Category::query()->insert($insertData);

                $categories = Category::all()->pluck('id', 'name')->toArray();

                $products = [];
                foreach ($responseData as $item) {
                    $rating = Arr::get($item, 'rating', []);
                    $products[] = [
                        'external_id'   => $item['id'],
                        'title'         => $item['title'],
                        'description'   => $item['description'],
                        'image'         => $item['image'],
                        'price'         => $item['price'],
                        'category_id'   => $categories[$item['category']],
                        'rating_rate'   => Arr::get($rating, 'rate'),
                        'rating_count'  => Arr::get($rating, 'count'),
                    ];
                }

                Product::query()->upsert($products, ['external_id'], [
                    'title', 'description', 'image', 'price', 'category_id', 'rating_rate', 'rating_count'
                ]);

            }
        } catch (ConnectionException $exception) {
            $log->error($exception->getMessage());
            // External Error report can be implemented here
        }
    }
}
