<?php

namespace App\Application\Project\Queries;

use App\Models\Project;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class GetOpenProjectsQuery
{
    public function handle(?string $cursor = null): CursorPaginator
    {
        $cacheKey = 'projects.open.' . ($cursor ?? 'first');
        return Cache::tags(['projects.open'])->flexible($cacheKey, [300, 600], function () use ($cursor) {
            return Project::open()
                ->with('client:id,name')
                ->latest()
                ->cursorPaginate(15, ['*'], 'cursor', $cursor);
        });
    }
}
