<?php

namespace App\Interfaces\Http\Controllers\Api\V1;

use App\Application\Project\Actions\CreateProjectAction;
use App\Application\Project\Actions\UpdateProjectAction;
use App\Application\Project\Queries\GetOpenProjectsQuery;
use App\Domain\Project\DTOs\CreateProjectDTO;
use App\Domain\Project\DTOs\UpdateProjectDTO;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Requests\CreateProjectRequest;
use App\Interfaces\Http\Requests\UpdateProjectRequest;
use App\Interfaces\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index(GetOpenProjectsQuery $getOpenProjectsQuery,Request $request)
    {
        $projects = $getOpenProjectsQuery->handle($request->query('cursor'));
        return response()->json([
            'data' => ProjectResource::collection($projects->items()),
            'next_cursor' => $projects->nextCursor()?->encode(),
            'prev_cursor' => $projects->previousCursor()?->encode(),
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

    public function update(UpdateProjectRequest $request,Project $project,UpdateProjectAction $updateProjectAction){
        $this->authorize('update', [Project::class,$project]);

        $result = $updateProjectAction->execute($project,UpdateProjectDTO::from($request->validated()));

        return response()->json([
            'data' => ProjectResource::make($result),
            'message' => 'Project updated successfully'
        ]);
    }

    public function destroy(Project $project){
        $this->authorize('delete', [Project::class,$project]);

        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }

}
