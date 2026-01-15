<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope; 

class FeaturedGroup extends Model
{
    protected $table = 'featured_groups';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'iamge',
        'is_active',
        'order'
    ];

    public function product() 
    {
        return $this->hasMany(Product::class);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', '1');
    }
}





 