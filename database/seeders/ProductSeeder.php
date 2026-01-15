<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\FeaturedGroup;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $tshirtCategory = Category::where('slug', 't-shirts')->first();
        $pantsCategory = Category::where('slug', 'pants')->first();
        $jacketsCategory = Category::where('slug', 'jackets')->first();
        $hoodiesCategory = Category::where('slug', 'hoodies')->first();
        $shoesCategory = Category::where('slug', 'shoes')->first();

        // Get featured groups
        $streetwear = FeaturedGroup::where('slug', 'streetwear')->first();
        $minimalist = FeaturedGroup::where('slug', 'minimalist')->first();
        $techwear = FeaturedGroup::where('slug', 'techwear')->first();

        $products = [
            // T-SHIRTS
            [
                'name' => 'Oversized Tee',
                'slug' => 'oversized-tee',
                'description' => 'Classic oversized fit t-shirt made from premium cotton. Perfect for streetwear looks.',
                'category_id' => $tshirtCategory->id,
                'featured_group_id' => $streetwear->id,
                'price' => 45000,
                'discount_price' => null,
                'stock' => 124,
                'sku' => 'VG-TSH-001',
                'size' => 'S,M,L,XL,XXL',
                'color' => 'Black,White,Gray',
                'is_trending' => true,
                'badge' => 'new',
                'status' => 'active',
            ],
            [
                'name' => 'Basic Tee',
                'slug' => 'basic-tee',
                'description' => 'Essential basic t-shirt. Minimalist design with superior comfort.',
                'category_id' => $tshirtCategory->id,
                'featured_group_id' => $minimalist->id,
                'price' => 35000,
                'discount_price' => null,
                'stock' => 200,
                'sku' => 'VG-TSH-002',
                'size' => 'S,M,L,XL',
                'color' => 'White,Black,Navy,Gray',
                'is_trending' => true,
                'badge' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Graphic Tee - Urban',
                'slug' => 'graphic-tee-urban',
                'description' => 'Bold graphic print t-shirt with urban-inspired artwork.',
                'category_id' => $tshirtCategory->id,
                'featured_group_id' => $streetwear->id,
                'price' => 49000,
                'discount_price' => null,
                'stock' => 85,
                'sku' => 'VG-TSH-003',
                'size' => 'M,L,XL,XXL',
                'color' => 'Black,White',
                'is_trending' => false,
                'badge' => 'hot',
                'status' => 'active',
            ],

            // PANTS
            [
                'name' => 'Cargo Pants',
                'slug' => 'cargo-pants',
                'description' => 'Utility-inspired cargo pants with multiple pockets. Comfortable and functional.',
                'category_id' => $pantsCategory->id,
                'featured_group_id' => $streetwear->id,
                'price' => 89000,
                'discount_price' => null,
                'stock' => 56,
                'sku' => 'VG-PNT-001',
                'size' => 'S,M,L,XL',
                'color' => 'Khaki,Black,Olive',
                'is_trending' => true,
                'badge' => 'hot',
                'status' => 'active',
            ],
            [
                'name' => 'Slim Jeans',
                'slug' => 'slim-jeans',
                'description' => 'Classic slim fit denim jeans. Versatile and timeless.',
                'category_id' => $pantsCategory->id,
                'featured_group_id' => $minimalist->id,
                'price' => 85000,
                'discount_price' => null,
                'stock' => 98,
                'sku' => 'VG-PNT-002',
                'size' => 'S,M,L,XL',
                'color' => 'Blue Denim,Black',
                'is_trending' => true,
                'badge' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Tech Joggers',
                'slug' => 'tech-joggers',
                'description' => 'Performance joggers with water-resistant fabric and zippered pockets.',
                'category_id' => $pantsCategory->id,
                'featured_group_id' => $techwear->id,
                'price' => 95000,
                'discount_price' => null,
                'stock' => 67,
                'sku' => 'VG-PNT-003',
                'size' => 'S,M,L,XL,XXL',
                'color' => 'Black,Gray,Navy',
                'is_trending' => false,
                'badge' => 'new',
                'status' => 'active',
            ],

            // JACKETS
            [
                'name' => 'Denim Jacket',
                'slug' => 'denim-jacket',
                'description' => 'Classic denim jacket with modern fit. A wardrobe staple.',
                'category_id' => $jacketsCategory->id,
                'featured_group_id' => $minimalist->id,
                'price' => 139000,
                'discount_price' => 99.00,
                'stock' => 0,
                'sku' => 'VG-JCK-001',
                'size' => 'M,L,XL',
                'color' => 'Light Denim,Dark Denim',
                'is_trending' => false,
                'badge' => 'sale',
                'status' => 'out_of_stock',
            ],
            [
                'name' => 'Bomber Jacket',
                'slug' => 'bomber-jacket',
                'description' => 'Street-style bomber jacket with ribbed cuffs and waistband.',
                'category_id' => $jacketsCategory->id,
                'featured_group_id' => $streetwear->id,
                'price' => 12900,
                'discount_price' => null,
                'stock' => 43,
                'sku' => 'VG-JCK-002',
                'size' => 'S,M,L,XL',
                'color' => 'Black,Olive,Navy',
                'is_trending' => true,
                'badge' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Tech Shell Jacket',
                'slug' => 'tech-shell-jacket',
                'description' => 'Waterproof technical jacket with adjustable hood and multiple pockets.',
                'category_id' => $jacketsCategory->id,
                'featured_group_id' => $techwear->id,
                'price' => 199000,
                'discount_price' => null,
                'stock' => 28,
                'sku' => 'VG-JCK-003',
                'size' => 'M,L,XL',
                'color' => 'Black,Gray',
                'is_trending' => false,
                'badge' => 'limited',
                'status' => 'active',
            ],

            // HOODIES
            [
                'name' => 'Tech Hoodie',
                'slug' => 'tech-hoodie',
                'description' => 'Premium tech fleece hoodie with ergonomic design and zippered pockets.',
                'category_id' => $hoodiesCategory->id,
                'featured_group_id' => $techwear->id,
                'price' => 79000,
                'discount_price' => null,
                'stock' => 8,
                'sku' => 'VG-HDY-001',
                'size' => 'S,M,L,XL',
                'color' => 'Black,Gray,Navy',
                'is_trending' => true,
                'badge' => 'new',
                'status' => 'active',
            ],
            [
                'name' => 'Zip Hoodie',
                'slug' => 'zip-hoodie',
                'description' => 'Classic full-zip hoodie in heavyweight cotton blend.',
                'category_id' => $hoodiesCategory->id,
                'featured_group_id' => $streetwear->id,
                'price' => 69000,
                'discount_price' => null,
                'stock' => 112,
                'sku' => 'VG-HDY-002',
                'size' => 'S,M,L,XL,XXL',
                'color' => 'Black,White,Gray,Burgundy',
                'is_trending' => true,
                'badge' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Minimalist Hoodie',
                'slug' => 'minimalist-hoodie',
                'description' => 'Clean, logo-free hoodie in premium organic cotton.',
                'category_id' => $hoodiesCategory->id,
                'featured_group_id' => $minimalist->id,
                'price' => 75000,
                'discount_price' => null,
                'stock' => 76,
                'sku' => 'VG-HDY-003',
                'size' => 'S,M,L,XL',
                'color' => 'White,Black,Gray,Beige',
                'is_trending' => false,
                'badge' => null,
                'status' => 'active',
            ],

            // SHOES
            [
                'name' => 'Street Sneakers',
                'slug' => 'street-sneakers',
                'description' => 'Low-top sneakers with cushioned sole. Perfect for everyday wear.',
                'category_id' => $shoesCategory->id,
                'featured_group_id' => $streetwear->id,
                'price' => 120000,
                'discount_price' => null,
                'stock' => 54,
                'sku' => 'VG-SHO-001',
                'size' => '39,40,41,42,43,44',
                'color' => 'White,Black,White/Black',
                'is_trending' => true,
                'badge' => 'hot',
                'status' => 'active',
            ],
            [
                'name' => 'Minimalist Sneakers',
                'slug' => 'minimalist-sneakers',
                'description' => 'Clean design sneakers in premium leather. Timeless and versatile.',
                'category_id' => $shoesCategory->id,
                'featured_group_id' => $minimalist->id,
                'price' => 110000,
                'discount_price' => 89.00,
                'stock' => 89,
                'sku' => 'VG-SHO-002',
                'size' => '39,40,41,42,43,44',
                'color' => 'White,Black',
                'is_trending' => false,
                'badge' => 'sale',
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}