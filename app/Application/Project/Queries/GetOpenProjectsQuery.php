<?php

namespace App\Application\Project\Queries;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class GetOpenProjectsQuery
{
    public function handle(): Collection
    {
        return Cache::flexible('projects.open', [300,600], function () {
            return Project::open()
                ->with('client:id,name')
                ->latest()
                ->get();
        });
    }
}
