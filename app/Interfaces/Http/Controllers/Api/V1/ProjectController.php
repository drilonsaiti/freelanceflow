<?php

namespace App\Interfaces\Http\Controllers\Api\V1;

use App\Application\Project\Actions\CreateProjectAction;
use App\Application\Project\Queries\GetOpenProjectsQuery;
use App\Domain\Project\DTOs\CreateProjectDTO;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Requests\CreateProjectRequest;
use App\Interfaces\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index(GetOpenProjectsQuery $getOpenProjectsQuery)
    {
        $projects = $getOpenProjectsQuery->handle();
        return response()->json([
            'data' => ProjectResource::collection($projects),
            'message' => 'Projects retrieved successfully'
        ]);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return response()->json([
            'data' => ProjectResource::make($project),
            'message' => 'Project retrieved successfully'
        ]);
    }

    public function store(CreateProjectRequest $request,CreateProjectAction $createProjectAction){
        $this->authorize('create', Project::class);

        $result = $createProjectAction->execute(CreateProjectDTO::from($request->validated()));

        return response()->json([
            'data' => ProjectResource::make($result),
            'message' => 'Project created successfully'
        ],201);
    }

}
