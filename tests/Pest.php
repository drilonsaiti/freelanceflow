<?php

use App\Domain\Identity\Enums\UserRole;
use App\Models\Contract;
use App\Models\Project;

uses(Tests\TestCase::class)->in('Feature');
uses(Tests\TestCase::class)->in('Unit');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function something()
{
    // ..
}

function makeUser(string $role = 'freelancer'): \App\Models\User
{
    return \App\Models\User::factory()->create([
        'role' => \App\Domain\Identity\Enums\UserRole::from($role),
    ]);
}

function createAcceptedContract(): array
{
    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);

    $proposalResponse = test()->actingAs($freelancer)
        ->postJson("api/v1/projects/{$project->ulid}/proposals", [
            'proposedRate'  => 1000,
            'estimatedDays' => 10,
            'coverLetter'   => 'Test proposal',
        ]);

    test()->actingAs($client)
        ->patchJson("api/v1/projects/{$project->ulid}/proposals/{$proposalResponse->json('data.id')}/accept");

    return [
        'client'     => $client,
        'freelancer' => $freelancer,
        'project'    => $project,
        'contract'   => Contract::where('project_id', $project->id)->first(),
    ];
}
