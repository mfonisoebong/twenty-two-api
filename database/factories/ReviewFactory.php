<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => random_int(1, 5),
            'email' => $user->email,
            'review' => fake()->sentence(),
            'nickname' => $user->full_name,
            'location' => fake()->city(),
            'bottom_line' => fake()->randomElement(['recommend', 'not_recommend', 'highly_recommend']),
            'image' => 'reviews/image.png',
            'video' => 'reviews/video.mp4',
        ];
    }
}
