<?php

namespace App\Domain\Project\Observer;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Enums\ProjectVisibility;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class ProjectObserver
{
    public function created(Project $project): void
    {
        if ($project->status === ProjectStatus::Open &&
            $project->visibility === ProjectVisibility::Public) {
            Cache::tags(['projects.open'])->flush();
        }
    }
}
