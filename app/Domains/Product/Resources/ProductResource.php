<?php

namespace App\Domains\Product\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Category\Resources\CategoryResource;

/**
 * @property \App\Models\Product $resource
*/
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->resource->id,
            'title'        => $this->resource->title,
            'description'  => $this->resource->description,
            'price'        => (float) $this->resource->price,
            'category'     => new CategoryResource($this->resource->category),
            'image'        => $this->resource->image
        ];
    }
}
