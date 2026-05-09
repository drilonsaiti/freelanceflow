<?php

namespace Projects;
use App\Application\Project\Queries\GetOpenProjectsQuery;
use App\Domain\Identity\Enums\UserRole;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;


uses(RefreshDatabase::class);

it('client can create a project',function () {

    $this->withoutExceptionHandling();

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
            'deadline' => Carbon::now()->addYear()->format('Y-m-d'),
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
            'deadline' => Carbon::now()->addYear()->format('Y-m-d'),
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
            'deadline' => Carbon::now()->addYear()->format('Y-m-d'),
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

it('returns cached projects on second request',function () {
    Cache::flush();

    Project::factory()->count(3)->create([
        'status' => 'open',
    ]);

    $query = new GetOpenProjectsQuery();

    $first = $query->handle();

    expect(Cache::has('projects.open'))->toBeTrue();

    $second = $query->handle();

    expect($second->count())->toBe($first->count());
});
it('invalidates project cache when new project is created',function (){
    $this->withoutExceptionHandling();

    Cache::put('projects.open',collect(['cached']),300);

    $user = makeUser(UserRole::Client->value);

    $this->actingAs($user)->postJson('api/v1/projects', [
        'title' => 'Test Project',
        'description' => 'This is a test project',
        'budgetMin' => 1000,
        'budgetMax' => 2000,
        'category' => 'Web Development',
        'status' => 'open',
        'visibility' => 'public',
        'requiredSkills' => ['PHP', 'Laravel'],
        'deadline' => Carbon::now()->addYear()->format('Y-m-d'),
    ])->assertCreated();

    expect(Cache::has('projects.open'))->toBeFalse();
});
