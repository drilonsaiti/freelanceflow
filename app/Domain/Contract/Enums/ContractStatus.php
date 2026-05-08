<?php

namespace App\Domain\Contract\Enums;

enum ContractStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Paused = 'paused';
    case Completed = 'completed';
    case Disputed = 'disputed';
    case Cancelled = 'cancelled';

    public function label(): string{
        return match($this){
            self::Draft => 'Draft',
            self::Active => 'Active',
            self::Paused => 'Paused',
            self::Completed => 'Completed',
            self::Disputed => 'Disputed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function canTransitionTo(self $new): bool
    {
        return match ($this) {

            self::Draft => in_array($new, [
                self::Active,
                self::Paused,
            ], true),

            self::Active => in_array($new, [
                self::Paused,
                self::Completed,
                self::Disputed,
                self::Cancelled,
            ], true),

            self::Paused => in_array($new, [
                self::Active,
                self::Completed,
                self::Disputed,
                self::Cancelled,
            ], true),

            self::Completed,
            self::Disputed,
            self::Cancelled => false,
        };
    }

}
