<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleModel>
 */
class ArticleModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'photo' => $this->faker->imageUrl(),
            'title' => $title,
            'slug' => Str::slug($title),
//            'slug' => $this->faker->slug(),
            'short_content' => $this->faker->text(100),
            'content' => $this->faker->text(),
        ];
    }
}
