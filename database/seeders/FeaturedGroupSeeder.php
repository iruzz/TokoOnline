<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FeaturedGroup;
use Illuminate\Support\Str;

class FeaturedGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $featuredGroups = [
            [
                'name' => 'Streetwear Collection',
                'slug' => 'streetwear',
                'description' => 'Bold urban style. Oversized fits. Exclusive pieces for those who stand out.',
                'image' => null, // Set later after upload
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Minimalist Essentials',
                'slug' => 'minimalist',
                'description' => 'Clean lines. Timeless basics. Wardrobe essentials that never go out of style.',
                'image' => null,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Tech Wear',
                'slug' => 'techwear',
                'description' => 'Functional future. Performance fabrics. Tech-inspired clothing for modern living.',
                'image' => null,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Summer Vibes',
                'slug' => 'summer',
                'description' => 'Light fabrics. Bright colors. Perfect for sunny days and beach vibes.',
                'image' => null,
                'is_active' => false, // Inactive for now
                'order' => 4,
            ],
        ];

        foreach ($featuredGroups as $group) {
            FeaturedGroup::create($group);
        }
    }
}