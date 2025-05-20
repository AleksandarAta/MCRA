<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Messeges>
 */
class MessegesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chatRoom_id' => 1,
            'from' => rand(11, 12),
            'body' => $this->faker->sentence(),
            'read' => false
        ];
    }
}
