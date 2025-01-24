<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->createMany([
            [
                'name' => 'Mens',
                'slug' => 'mens',
                'featured_image' => "categories/men.png",
                'is_featured' => true
            ],
            [
                'name' => 'Womens',
                'slug' => 'womens',
                'featured_image' => "categories/women.png",
                'is_featured' => true
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'featured_image' => "categories/accessories.png",
                'is_featured' => true
            ],
            [
                'name' => 'Kids',
                'slug' => 'kids',
                'featured_image' => null,
                'is_featured' => false

            ],
            [
                'name' => 'New arrival',
                'slug' => 'new-arrival',
                'featured_image' => null,
                'is_featured' => false

            ]
        ]);
    }
}
