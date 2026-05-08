<?php

namespace Projects;
use App\Domain\Identity\Enums\UserRole;
use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Enums\ProjectVisibility;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Log;

uses(RefreshDatabase::class);

it('client can create a project',function () {
    $user = makeUser(UserRole::Client->value);

    $response = $this
        ->actingAs($user)
        ->postJson('api/v1/projects', [
            'title' => 'Test Project',
            'description' => 'This is a test project',
            'budgetMin' => 1000,
            'budgetMax' => 2000,
            'category' => 'Web Development',
            'status' => 'open',
            'visibility' => 'public',
            'requiredSkills' => ['PHP', 'Laravel'],
            'deadline' => '2027-01-01',
        ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'message' => 'Project created successfully',
        ]);
});
it('freelancer cannot create a project',function () {
    $user = makeUser(UserRole::Freelancer->value);

    $response = $this
        ->actingAs($user)
        ->postJson('api/v1/projects', [
            'title' => 'Test Project',
            'description' => 'This is a test project',
            'budgetMin' => 1000,
            'budgetMax' => 2000,
            'category' => 'Web Development',
            'status' => 'open',
            'visibility' => 'public',
            'requiredSkills' => ['PHP', 'Laravel'],
            'deadline' => '2027-01-01',
        ]);

    $response->assertStatus(403)
        ->assertJsonFragment([
            'message' => 'This action is unauthorized.',
        ]);
});
it('guest cannot create a project',function () {
    $response = $this
        ->postJson('api/v1/projects', [
            'title' => 'Test Project',
            'description' => 'This is a test project',
            'budgetMin' => 1000,
            'budgetMax' => 2000,
            'category' => 'Web Development',
            'status' => 'open',
            'visibility' => 'public',
            'requiredSkills' => ['PHP', 'Laravel'],
            'deadline' => '2027-01-01',
        ]);

    $response->assertStatus(401)
        ->assertJsonFragment([
            'message' => 'Unauthenticated.',
        ]);
});
it('returns open public projects for any authenticated user', function () {

    $user = makeUser();

    Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
    ]);

    Project::factory()->create([
        'status' => 'draft',
        'visibility' => 'public',
    ]);

    Project::factory()->create([
        'status' => 'open',
        'visibility' => 'private',
    ]);

    $response = $this->actingAs($user)->getJson('api/v1/projects');

    $response->assertOk();

    expect($response->json('data'))->toHaveCount(1);
});

it('client can view their own private project',function () {

    $user = makeUser(UserRole::Client->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'private',
        'client_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->getJson('api/v1/projects/' . $project->ulid);

    $response->assertOk();

    expect($response->json('data.id'))->toBe($project->ulid);
});
it('freelancer cannot view a private project they do not own',function () {
    $user = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'private',
    ]);

    $response = $this->actingAs($user)->getJson('api/v1/projects/' . $project->ulid);

    $response->assertForbidden();

});
it('project has correct resource structure',function () {
    $user = makeUser(UserRole::Client->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'private',
        'client_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->getJson('api/v1/projects/' . $project->ulid);

    $response->assertOk()
    ->assertJsonStructure([
        'data' => [
            'id',
            'title',
            'description',
            'budget',
            'status',
            'visibility',
            'category',
            'required_skills',
            'deadline',
            'client',
            'created_at',
        ]
    ]);
});
