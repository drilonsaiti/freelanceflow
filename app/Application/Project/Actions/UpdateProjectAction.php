<?php

namespace App\Application\Project\Actions;

use App\Domain\Project\DTOs\UpdateProjectDTO;
use App\Models\Project;

final class UpdateProjectAction
{

    public function execute(Project $project, UpdateProjectDTO $dto): Project
    {
        $project->update([
            'title' => $dto->title ?? $project->title,
            'description' => $dto->description ?? $project->description,
            'status' => $dto->status ?? $project->status,
            'visibility' => $dto->visibility ?? $project->visibility,
            'budget_min' => $dto->budgetMin ?? $project->budget_min,
            'budget_max' => $dto->budgetMax ?? $project->budget_max,
            'required_skills' => $dto->requiredSkills ?? $project->required_skills,
            'deadline' => $dto->deadline ?? $project->deadline,
        ]);

        return $project->fresh();
    }
}
