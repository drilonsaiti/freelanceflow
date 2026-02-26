<?php

namespace App\Domain\Identity\DTOs;

use App\Domain\Identity\Enums\UserRole;
use Spatie\LaravelData\Data;

final class RegisterUserDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly UserRole $role = UserRole::Freelancer,
    ) {}
}
