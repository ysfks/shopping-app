<?php
namespace App\Domains\Product\Jobs;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;

class CollectProductsJob
{
    public function handle(Request $request): Paginator
    {
        $query = Product::query();

        if ($search = $request->string('q')->toString()) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($category = $request->integer('category')) {
            $query->where('category_id', $category);
        }

        return $query->orderByDesc('id')->paginate($request->integer('per_page', 10));
    }
}

