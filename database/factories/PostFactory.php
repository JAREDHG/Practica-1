<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(5, true),
            'views' => $this->faker->numberBetween(0, 1000),
            'published_at' => $this->faker->optional()->dateTime(),
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => $this->faker->dateTime(),
            ];
        });
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }
}