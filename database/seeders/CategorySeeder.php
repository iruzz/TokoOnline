<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'T-Shirts',
                'slug' => 't-shirts',
                'description' => 'Comfortable and stylish t-shirts for everyday wear',
                'icon' => '👕',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Pants',
                'slug' => 'pants',
                'description' => 'Trendy pants and trousers for all occasions',
                'icon' => '👖',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Jackets',
                'slug' => 'jackets',
                'description' => 'Premium jackets to keep you warm and stylish',
                'icon' => '🧥',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Hoodies',
                'slug' => 'hoodies',
                'description' => 'Cozy hoodies for casual and streetwear looks',
                'icon' => '🧥',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Shoes',
                'slug' => 'shoes',
                'description' => 'Footwear for comfort and style',
                'icon' => '👟',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}