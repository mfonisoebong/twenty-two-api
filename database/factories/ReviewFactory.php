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
            'review' => fake()->sentence(),
            'headline' => fake()->sentence(),
            'nickname' => $user->full_name,
            'location' => fake()->city(),
            'width' => fake()->randomElement(['narrow', 'fitted', 'wide']),
            'fit_report' => fake()->randomElement(['small', 'fitted', 'large']),
            'comfort' => fake()->randomElement(['uncomfortable', 'comfortable', 'very_comfortable']),
            'durability' => fake()->randomElement(['not_durable', 'durable', 'very_durable']),
            'bottom_line' => fake()->randomElement(['recommend', 'not_recommend', 'highly_recommend']),
            'image' => 'reviews/image.png',
            'video' => 'reviews/video.mp4',
        ];
    }
}
