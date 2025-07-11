<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commend>
 */
class CommendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::select('id')->get();


        return [
            'user_id' => $users->random(),
            'commendee_id' => User::inRandomOrder()->first()->id,
            'commend' => $this->faker->text(),
        ];
    }
}
