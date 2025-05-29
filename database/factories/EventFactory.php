<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    public function definition(): array
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'editor');
        })->select('id')->get();

        return [
            'title' => $this->faker->sentence(3, false),
            'location' => $this->faker->address(),
            'text' => $this->faker->text(),
            'user_id' => $users->random()->id,
            'date' => Carbon::now()->addMonth(rand(1, 10)),
        ];
    }
}
