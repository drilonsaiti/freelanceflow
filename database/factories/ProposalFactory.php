<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
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

            'project_id' => Project::factory(),
            'freelancer_id' => User::factory(),

            'cover_letter' => fake()->paragraph(),
            'proposed_rate' => fake()->numberBetween(50, 1000),
            'estimated_days' => fake()->numberBetween(1, 30),

            'status' => 'pending',
        ];
    }
}
