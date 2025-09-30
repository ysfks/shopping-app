<?php
namespace App\Domains\Category\Jobs;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CollectCategoriesJob
{
    public function handle(): Collection
    {
        return Category::all();
    }
}

