<?php

namespace Domain\Identity;

use App\Domain\Identity\Enums\UserRole;
use ValueError;

it('returns correct label for each role', function () {

    expect(UserRole::Freelancer->label())->toBe('Freelancer');
    expect(UserRole::Client->label())->toBe('Client');
    expect(UserRole::Admin->label())->toBe('Admin');

});
it('can be created from valid string value', function () {

    expect(UserRole::from('freelancer'))->toBe(UserRole::Freelancer);
    expect(UserRole::from('client'))->toBe(UserRole::Client);
    expect(UserRole::from('admin'))->toBe(UserRole::Admin);

});
it('throws on invalid string value', function () {

    expect(fn () => UserRole::from('invalid'))
        ->toThrow(ValueError::class);

});
