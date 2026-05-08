<?php

namespace Contracts;

use App\Domain\Contract\Jobs\SendContractCreatedNotification;
use App\Domain\Identity\Enums\UserRole;
use App\Infrastructure\Mail\ContractCreatedClientMail;
use App\Infrastructure\Mail\ContractCreatedFreelancerMail;
use App\Models\Contract;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('contract is created automatically when proposal is accepted', function () {
    ['project' => $project, 'freelancer' => $freelancer] = createAcceptedContract();

    $contract = Contract::where('project_id', $project->id)
        ->where('freelancer_id', $freelancer->id)
        ->first();

    expect($contract)->not->toBeNull();
});

it('freelancer can view their own contracts', function () {
    ['freelancer' => $freelancer, 'contract' => $contract] = createAcceptedContract();

    $this->actingAs($freelancer)
        ->getJson("api/v1/contracts/{$contract->ulid}")
        ->assertOk();
});

it('client can view their own contracts', function () {
    ['client' => $client, 'contract' => $contract] = createAcceptedContract();

    $response = $this->actingAs($client)
        ->getJson("api/v1/contracts/{$contract->ulid}");

    $response->assertOk();

    expect($response->json('data.id'))->toBe($contract->ulid);
});

it('freelancer cannot view contracts they are not part of', function () {
    ['contract' => $contract] = createAcceptedContract();

    $freelancer2 = makeUser(UserRole::Freelancer->value);

    $this->actingAs($freelancer2)
        ->getJson("api/v1/contracts/{$contract->ulid}")
        ->assertForbidden();
});

it('activity log is written when contract is created', function () {
    ['contract' => $contract] = createAcceptedContract();

    $activity = $contract->activities()->first();

    expect($activity->event)->toBe('created');
});

it('activity log is written when contract status changes', function () {
    ['contract' => $contract] = createAcceptedContract();

    $oldStatus = $contract->status;

    $contract->update([
        'status' => 'completed',
    ]);

    $activity = $contract->activities()
        ->where('event', 'status_changed')
        ->first();

    expect($activity)->not->toBeNull();

    expect($activity->properties['old_status'])->toBe($oldStatus->value);
    expect($activity->properties['new_status'])->toBe('completed');
});

it('mail is sent to freelancer when contract is created', function () {
    Mail::fake();

    $contract = Contract::factory()->create();

    SendContractCreatedNotification::dispatchSync($contract);

    Mail::assertSent(ContractCreatedFreelancerMail::class, function ($mail) use ($contract) {
        return $mail->contract->id === $contract->id;
    });
});

it('mail is sent to client when contract is created', function () {
    Mail::fake();

    $contract = Contract::factory()->create();

    SendContractCreatedNotification::dispatchSync($contract);

    Mail::assertSent(ContractCreatedClientMail::class, function ($mail) use ($contract) {
        return $mail->contract->id === $contract->id;
    });
});

