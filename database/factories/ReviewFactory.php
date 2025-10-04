<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(3, 5),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'is_fake' => false,
        ];
    }
}
