<?php

namespace Proposals;

use App\Domain\Identity\Enums\UserRole;
use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Proposal\Enums\ProposalStatus;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('freelancer can submit a proposal to an open project',function(){

    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'project_id',
                'freelancer',
                'proposed_rate',
            ],
            'message',
        ]);

    expect($response->json('data.project_id'))->toBe($project->ulid);
});

it('freelancer cannot submit two proposals to the same project',function() {

    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'project_id',
                'freelancer',
                'proposed_rate',
            ],
            'message',
        ]);

    expect($response->json('data.project_id'))->toBe($project->ulid);

    $response2 = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response2->assertStatus(422)
        ->assertJsonValidationErrors([
            'proposal'
        ]);

});
it('client cannot submit a proposal',function () {
    $client = makeUser(UserRole::Client->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($client)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response->assertForbidden();
});
it('cannot submit proposal to a non-open project',function () {
    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'draft',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'project'
        ]);
});
it('client can view proposals on their own project',function () {
    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response->assertCreated();

    $response2 = $this->actingAs($client)->getJson("api/v1/projects/{$project->ulid}/proposals");

    $response2->assertOk();

    expect($response2->json('data'))->toHaveCount(1);
});
it('freelancer cannot view proposals on a project they do not own',function () {
    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);
    $freelancer2 = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $response->assertCreated();

    $response2 = $this->actingAs($freelancer2)->getJson("api/v1/projects/{$project->ulid}/proposals");

    $response2->assertForbidden();

});
it('accepting a proposal rejects all other proposals', function () {
    $client = makeUser(UserRole::Client->value);
    $freelancer1 = makeUser(UserRole::Freelancer->value);
    $freelancer2 = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);

    $proposal1 = $this->actingAs($freelancer1)
        ->postJson("api/v1/projects/{$project->ulid}/proposals", [
            'proposedRate' => 1000, 'estimatedDays' => 10, 'coverLetter' => 'Proposal 1',
        ]);

    $proposal2 = $this->actingAs($freelancer2)
        ->postJson("api/v1/projects/{$project->ulid}/proposals", [
            'proposedRate' => 900, 'estimatedDays' => 8, 'coverLetter' => 'Proposal 2',
        ]);

    $this->actingAs($client)
        ->patchJson("api/v1/projects/{$project->ulid}/proposals/{$proposal1->json('data.id')}/accept")
        ->assertOk();

    $this->assertDatabaseHas('proposals', [
        'ulid'   => $proposal2->json('data.id'),
        'status' => ProposalStatus::Rejected->value,
    ]);
});
it('accepting a proposal sets project status to in_progress', function () {
    ['client' => $client, 'project' => $project] = createAcceptedContract();

    expect($project->fresh()->status)->toBe(ProjectStatus::InProgress);
});

it('only client can accept a proposal',function () {

    $client = makeUser(UserRole::Client->value);
    $freelancer = makeUser(UserRole::Freelancer->value);

    $project = Project::factory()->create([
        'status' => 'open',
        'visibility' => 'public',
        'client_id' => $client->id,
    ]);


    $response = $this->actingAs($freelancer)->postJson("api/v1/projects/{$project->ulid}/proposals", [
        'proposedRate' => 1000,
        'estimatedDays' => 10,
        'coverLetter' => 'This is a test proposal',
    ]);

    $proposalUlid = $response->json('data.id');

    $response->assertCreated();

    $response2 = $this->actingAs($freelancer)->patchJson("api/v1/projects/{$project->ulid}/proposals/{$proposalUlid}/accept");

    $response2->assertForbidden();
});
