<?php

namespace App\Domain\Proposal\Policies;

use App\Domain\Identity\Enums\UserRole;
use App\Domain\Proposal\Enums\ProposalStatus;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;

class ProposalPolicy
{
    public function viewAny(User $user, Project $project): bool
    {
        return $user->id === $project->client_id;
    }

    public function viewMine(User $user, Project $project): bool
    {
        return $project->proposals()
            ->where('freelancer_id', $user->id)
            ->exists();
    }
    public function create(User $user,): bool
    {
        return $user->role === UserRole::Freelancer;
    }

    public function accept(User $user,Proposal $proposal): bool
    {
        return $user->id === $proposal->project->client_id;
    }

    public function withdraw(User $user,Proposal $proposal): bool
    {
        return $user->id === $proposal->project->client_id
            && $proposal->status === ProposalStatus::Pending;
    }
}
