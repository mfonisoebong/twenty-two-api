<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random integer
        $basePrice = fake()->numberBetween(10, 300);
        $discountedPrice = fake()->numberBetween(2, $basePrice);
        return [
            'name' => fake()->word(),
            'featured_image' => fake()->randomElement([
                'products/tshirt.jpeg',
                'products/sweatshirt.jpeg',
                'products/hoodie.jpeg',
            ]),
            'additional_images' => implode(',', [
                'products/tshirt.jpeg',
                'products/sweatshirt.jpeg',
                'products/hoodie.jpeg',
            ]),
            'shipping_details' => fake()->paragraph(),
            'base_price' => $basePrice,
            'discounted_price' => $discountedPrice,
            'colors' => json_encode(fake()->randomElements([
                [
                    'name' => 'Red',
                    'color' => 'red'
                ],
                [
                    'name' => 'Blue',
                    'color' => 'blue'
                ],
                [
                    'name' => 'Green',
                    'color' => 'green'
                ],
                [
                    'name' => 'Yellow',
                    'color' => 'yellow'
                ],
                [
                    'name' => 'Purple',
                    'color' => 'purple'
                ],
                [
                    'name' => 'Pink',
                    'color' => 'pink'
                ],
                [
                    'name' => 'Orange',
                    'color' => 'orange'
                ],
                [
                    'name' => 'Gray',
                    'color' => 'gray'
                ],
                [
                    'name' => 'Black',
                    'color' => 'black'
                ],
                [
                    'name' => 'White',
                    'color' => 'white'
                ],
            ], 3, false)),
            'colors_list' => implode(',', ['Red', 'Blue', 'Green', 'Yellow', 'Purple', 'Pink', 'Orange', 'Gray', 'Black', 'White']),
            'sizes' => implode(',', ['S', 'M', 'L', 'XL']),
            'available_units' => fake()->numberBetween(1, 1000),
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => fake()->paragraphs(2, true),
        ];
    }
}
