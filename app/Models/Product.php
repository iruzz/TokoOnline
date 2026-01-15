<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope; 



class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'category_id', 'featured_group_id',
        'price', 'discount_price', 'stock', 'sku', 'size', 'color',
        'is_trending', 'badge', 'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_trending' => 'boolean',
    ];

    // RELATIONSHIPS (WAJIB!)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function featuredGroup()
    {
        return $this->belongsTo(FeaturedGroup::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

        // SCOPE: Active products (WAJIB!)
         #[Scope]
        protected function active($query)
        {
            return $query->where('status', 'active');
        }

        // HELPER: Check stock (WAJIB!)
        public function isInStock()
        {
            return $this->stock > 0 && $this->status !== 'out_of_stock';
        }

        // HELPER: Final price (WAJIB!)
        public function getFinalPriceAttribute()
        {
            return $this->discount_price ?? $this->price;
        }

        #[Scope]
        public function newArrival($query) {
            return $query->where('is_new', 1);
        }

        #[Scope]
        public function isTrending(Builder $query):void
        {
            $query->where('is_trending', 1);
        }
}