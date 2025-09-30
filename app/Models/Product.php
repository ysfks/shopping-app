<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $external_id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property float $price
 * @property string $category
 * @property float|null $rating_rate
 * @property int|null $rating_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'external_id',
        'title',
        'description',
        'image',
        'price',
        'category',
        'category_id',
        'rating_rate',
        'rating_count',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
