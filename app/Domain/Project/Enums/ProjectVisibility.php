<?php

namespace App\Domain\Project\Enums;

enum ProjectVisibility: string
{
    case Public = 'public';
    case Private = 'private';
    case InviteOnly = 'invite_only';

    public function label(): string {
        return match($this){
            self::Public => 'Public',
            self::Private => 'Private',
            self::InviteOnly => 'Invite Only',
        };
    }

}
