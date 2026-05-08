<?php

namespace Domain\Contract;

use App\Domain\Contract\Enums\ContractStatus;

it('prevents transitions from completed', function () {
    foreach (ContractStatus::cases() as $status) {
        expect(ContractStatus::Completed->canTransitionTo($status))->toBeFalse();
    }
});

it('prevents transitions from cancelled', function () {
    foreach (ContractStatus::cases() as $status) {
        expect(ContractStatus::Cancelled->canTransitionTo($status))->toBeFalse();
    }
});

it('prevents transitions from disputed', function () {
    foreach (ContractStatus::cases() as $status) {
        expect(ContractStatus::Disputed->canTransitionTo($status))->toBeFalse();
    }
});

it('draft allows only active or paused', function () {
    expect(ContractStatus::Draft->canTransitionTo(ContractStatus::Active))->toBeTrue();
    expect(ContractStatus::Draft->canTransitionTo(ContractStatus::Paused))->toBeTrue();

    expect(ContractStatus::Draft->canTransitionTo(ContractStatus::Completed))->toBeFalse();
    expect(ContractStatus::Draft->canTransitionTo(ContractStatus::Disputed))->toBeFalse();
    expect(ContractStatus::Draft->canTransitionTo(ContractStatus::Cancelled))->toBeFalse();
});

it('active allows valid transitions', function () {
    expect(ContractStatus::Active->canTransitionTo(ContractStatus::Paused))->toBeTrue();
    expect(ContractStatus::Active->canTransitionTo(ContractStatus::Completed))->toBeTrue();
    expect(ContractStatus::Active->canTransitionTo(ContractStatus::Disputed))->toBeTrue();
    expect(ContractStatus::Active->canTransitionTo(ContractStatus::Cancelled))->toBeTrue();

    expect(ContractStatus::Active->canTransitionTo(ContractStatus::Draft))->toBeFalse();
});

it('paused allows valid transitions', function () {
    expect(ContractStatus::Paused->canTransitionTo(ContractStatus::Active))->toBeTrue();
    expect(ContractStatus::Paused->canTransitionTo(ContractStatus::Completed))->toBeTrue();
    expect(ContractStatus::Paused->canTransitionTo(ContractStatus::Disputed))->toBeTrue();
    expect(ContractStatus::Paused->canTransitionTo(ContractStatus::Cancelled))->toBeTrue();

    expect(ContractStatus::Paused->canTransitionTo(ContractStatus::Draft))->toBeFalse();
});
