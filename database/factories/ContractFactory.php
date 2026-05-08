<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
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
            'client_id' => User::factory(),
            'freelancer_id' => User::factory(),
            'proposal_id' => Proposal::factory(),

            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'rate' => fake()->numberBetween(50, 500),
            'rate_type' => 'hourly',
            'estimated_days' => fake()->numberBetween(1, 30),

            'status' => 'active',
        ];
    }
}
