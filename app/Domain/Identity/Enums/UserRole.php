<?php

namespace App\Domain\Identity\Enums;

enum UserRole: string
{
    case Freelancer = 'freelancer';
    case Client = 'client';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Freelancer => 'Freelancer',
            self::Client => 'Client',
            self::Admin => 'Admin',
        };
    }
}
