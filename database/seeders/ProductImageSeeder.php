<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy image URLs from Unsplash (fashion/clothing)
        $images = [
            // T-Shirts
            'tshirts' => [
                'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800',
                'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=800',
                'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800',
            ],
            // Pants
            'pants' => [
                'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=800',
                'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800',
                'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800',
            ],
            // Jackets
            'jackets' => [
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800',
                'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800',
                'https://images.unsplash.com/photo-1543076659-9380cdf10613?w=800',
            ],
            // Hoodies
            'hoodies' => [
                'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800',
                'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800',
                'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800',
            ],
            // Shoes
            'shoes' => [
                'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800',
                'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=800',
                'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=800',
            ],
        ];

        // Get all products
        $products = Product::all();

        foreach ($products as $index => $product) {
            // Determine image category based on product category
            $categorySlug = $product->category->slug ?? 'tshirts';
            
            // Map category to image array
            $imageArray = match($categorySlug) {
                't-shirts' => $images['tshirts'],
                'pants' => $images['pants'],
                'jackets' => $images['jackets'],
                'hoodies' => $images['hoodies'],
                'shoes' => $images['shoes'],
                default => $images['tshirts'],
            };

            // Create 2-3 images per product
            $imageCount = rand(2, 3);
            
            for ($i = 0; $i < $imageCount; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageArray[$i % count($imageArray)],
                    'is_primary' => $i === 0, // First image is primary
                    'order' => $i,
                ]);
            }
        }
    }
}