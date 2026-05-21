<?php

namespace App\Domain\Project\Policies;

use App\Domain\Identity\Enums\UserRole;
use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Enums\ProjectVisibility;
use App\Models\Project;
use App\Models\User;
use Log;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Project $project): bool
    {
        if ($project->visibility === ProjectVisibility::Public){
            return true;
        }
        return $user->id === $project->client_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        \Log::info(json_encode($user));
        return $user->role === UserRole::Client;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->client_id
            && $project->status !== ProjectStatus::Completed
            && $project->status !== ProjectStatus::Cancelled;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->client_id;
    }

    public function restore(User $user, Project $project): bool
    {
        return $user->id === $project->client_id;
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->id === $project->client_id;
    }
}
