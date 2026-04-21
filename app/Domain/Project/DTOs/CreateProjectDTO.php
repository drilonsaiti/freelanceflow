<?php

namespace App\Domain\Project\DTOs;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Enums\ProjectVisibility;
use Spatie\LaravelData\Data;

final class CreateProjectDTO extends Data
{

    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?float $budgetMin,
        public readonly ?float $budgetMax,
        public readonly ProjectStatus $status,
        public readonly ProjectVisibility $visibility,
        public readonly ?string $category,
        public readonly ?array $requiredSkills,
        public readonly ?string $deadline,
    ) {}
}
