<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'is_completed' => fake()->boolean,
            'user_id' => \App\Models\User::factory(),
            'description' => fake()->text(200)
        ];
    }
}
