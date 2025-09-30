<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Domains\Product\Jobs\CollectProductsJob;
use App\Domains\Product\Resources\ProductResource;

class CollectProductsController extends Controller
{
    public function __invoke()
    {
        $products = $this->dispatchSync(new CollectProductsJob);

        return ProductResource::collection($products);
    }
}
