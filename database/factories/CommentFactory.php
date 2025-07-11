<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $users = User::select('id')->get();
        $blogs = Blog::select('id')->get();


        return [
            'user_id' => $users->random(),
            'blog_id' => $blogs->random(),
            'body' => $this->faker->text(rand(10, 50))
        ];
    }
}
