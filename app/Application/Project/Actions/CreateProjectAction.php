<?php

namespace App\Application\Project\Actions;

use App\Domain\Project\DTOs\CreateProjectDTO;
use App\Models\Project;

final class CreateProjectAction
{

    public function execute(CreateProjectDTO $dto): Project{
        return Project::create([
            'ulid' => (string) \Illuminate\Support\Str::ulid(),
            'title' => $dto->title,
            'description' => $dto?->description,
            'budget_min' => $dto?->budgetMin,
            'budget_max' => $dto?->budgetMax,
            'status' => $dto->status,
            'visibility' => $dto->visibility,
            'category' => $dto->category,
            'client_id' => auth()->id(),
            'required_skills' => $dto->requiredSkills,
            'deadline' => $dto->deadline,
        ]);
    }
}
