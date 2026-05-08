<?php

namespace Domain\Project;

use App\Domain\Project\Enums\ProjectStatus;

it('does not allow completed to transition to any status', function () {
    foreach (ProjectStatus::cases() as $status) {
        expect(ProjectStatus::Completed->canTransitionTo($status))->toBeFalse();
    }
});
it('does not allow cancelled to transition to any status', function () {
    foreach (ProjectStatus::cases() as $status) {
        expect(ProjectStatus::Cancelled->canTransitionTo($status))->toBeFalse();
    }
});
it('allows draft to transition to open and in_progress', function () {
    expect(ProjectStatus::Draft->canTransitionTo(ProjectStatus::Open))->toBeTrue();
    expect(ProjectStatus::Draft->canTransitionTo(ProjectStatus::InProgress))->toBeTrue();

    expect(ProjectStatus::Draft->canTransitionTo(ProjectStatus::Completed))->toBeFalse();
    expect(ProjectStatus::Draft->canTransitionTo(ProjectStatus::Cancelled))->toBeFalse();
});
it('allows open to transition correctly', function () {
    expect(ProjectStatus::Open->canTransitionTo(ProjectStatus::InProgress))->toBeTrue();
    expect(ProjectStatus::Open->canTransitionTo(ProjectStatus::Completed))->toBeTrue();
    expect(ProjectStatus::Open->canTransitionTo(ProjectStatus::Cancelled))->toBeTrue();

    expect(ProjectStatus::Open->canTransitionTo(ProjectStatus::Draft))->toBeFalse();
});
it('allows in_progress to transition only to terminal states', function () {
    expect(ProjectStatus::InProgress->canTransitionTo(ProjectStatus::Completed))->toBeTrue();
    expect(ProjectStatus::InProgress->canTransitionTo(ProjectStatus::Cancelled))->toBeTrue();

    expect(ProjectStatus::InProgress->canTransitionTo(ProjectStatus::Open))->toBeFalse();
    expect(ProjectStatus::InProgress->canTransitionTo(ProjectStatus::Draft))->toBeFalse();
});
