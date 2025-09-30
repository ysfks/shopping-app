<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Domains\Category\Jobs\CollectCategoriesJob;
use App\Domains\Category\Resources\CategoryResource;

class CollectCategoriesController extends Controller
{
    public function __invoke()
    {
        $categories = $this->dispatchSync(new CollectCategoriesJob);

        return CategoryResource::collection($categories);
    }
}
