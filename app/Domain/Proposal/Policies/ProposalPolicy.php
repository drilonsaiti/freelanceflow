<?php

namespace App\Domain\Proposal\Policies;

use App\Domain\Identity\Enums\UserRole;
use App\Models\Project;
use App\Models\User;

class ProposalPolicy
{

    public function create(User $user, Project $project): bool
    {
        return $user->role === UserRole::Freelancer;
    }

    public function accept(User $user,Project $project): bool
    {
        return $user->id === $project->client_id;
    }
}
