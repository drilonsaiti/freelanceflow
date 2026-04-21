<?php

namespace App\Application\Project\Actions;

use App\Domain\Project\DTOs\CreateProjectDTO;
use App\Models\Project;

final class CreateProjectAction
{

    public function execute(CreateProjectDTO $dto): Project{
        return Project::create([
            'name' => $dto->name,
            'description' => $dto?->description,
            'budget_min' => $dto?->budgetMin,
            'budget_max' => $dto?->budgetMax,
            'status' => $dto->status,
            'visibility' => $dto->visibility,
            'category' => $dto->category,
            'required_skills' => $dto->requiredSkills,
            'deadline' => $dto->deadline,
        ]);
    }
}
