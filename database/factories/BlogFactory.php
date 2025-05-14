<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
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
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'body' => $this->faker->text(),
            'publish' => rand(0, 1),
            'keywords' => implode(', ', $this->faker->words(rand(3, 5))),
            'image' => "http://mcra.local/images/profile-image.jpg",
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
