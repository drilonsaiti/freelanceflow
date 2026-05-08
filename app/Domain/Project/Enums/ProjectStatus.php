<?php

namespace App\Domain\Project\Enums;

enum ProjectStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Open',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function canTransitionTo(self $new): bool
    {
        return match ($this) {
            self::Draft => in_array($new,[self::Open,self::InProgress],true),
            self::Open => in_array($new,[self::InProgress,self::Completed,self::Cancelled],true),
            self::InProgress => in_array($new,[self::Completed,self::Cancelled],true),
            self::Completed,
            self::Cancelled => false,
        };
    }

}
