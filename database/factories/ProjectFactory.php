<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ulid' => (string) \Illuminate\Support\Str::ulid(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'budget_min' => 1000,
            'budget_max' => 5000,
            'status' => 'open',
            'visibility' => 'public',
            'client_id' => User::factory(),
        ];
    }
}
