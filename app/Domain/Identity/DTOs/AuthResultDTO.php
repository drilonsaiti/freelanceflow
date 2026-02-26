<?php

namespace App\Domain\Identity\DTOs;

use App\Models\User;

final class AuthResultDTO
{
    public function __construct(
        public readonly User $user,
        public readonly string $token,
    ) {}
}
