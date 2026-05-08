<?php

namespace Application\Identity;

use App\Domain\Identity\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a user with correct attributes', function () {

    $this->withoutExceptionHandling();
    $action = new \App\Application\Identity\Actions\RegisterUserAction();

    $dto = \App\Domain\Identity\DTOs\RegisterUserDTO::from([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'role' => \App\Domain\Identity\Enums\UserRole::Client,
    ]);

    $result = $action->execute($dto);

    expect($result->user->name)->toBe('John Doe');
    expect($result->user->email)->toBe('john@example.com');
    expect($result->user->role)->toBe(UserRole::Client);
});

it('hashes the password', function () {

    $action = new \App\Application\Identity\Actions\RegisterUserAction();

    $dto = \App\Domain\Identity\DTOs\RegisterUserDTO::from([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret-password',
        'role' => \App\Domain\Identity\Enums\UserRole::Client,
    ]);

    $result = $action->execute($dto);

    expect($result->user->password)
        ->not->toBe('secret-password')
        ->and(password_verify('secret-password', $result->user->password))->toBeTrue();
});
it('assigns default freelancer role when none provided', function () {

    $action = new \App\Application\Identity\Actions\RegisterUserAction();

    $dto = \App\Domain\Identity\DTOs\RegisterUserDTO::from([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret-password',
        // role missing intentionally
    ]);

    $result = $action->execute($dto);

    expect($result->user->role)->toBe(UserRole::Freelancer);
});
it('returns AuthResultDTO with user and token', function () {

    $action = new \App\Application\Identity\Actions\RegisterUserAction();

    $dto = \App\Domain\Identity\DTOs\RegisterUserDTO::from([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret-password',
        'role' => \App\Domain\Identity\Enums\UserRole::Client,
    ]);

    $result = $action->execute($dto);

    expect($result->user)->toBeInstanceOf(\App\Models\User::class);
    expect($result->token)->toBeString()->not->toBeEmpty();
});
