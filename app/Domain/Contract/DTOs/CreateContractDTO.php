<?php

namespace App\Domain\Contract\DTOs;

use App\Domain\Contract\Enums\RateType;

final class CreateContractDTO
{
    public function __construct(
        public readonly int $projectId,
        public readonly int $freelancerId,
        public readonly int $clientId,
        public readonly int $proposalId,
        public readonly string $title,
        public readonly float $rate,
        public readonly RateType $rateType,
        public readonly int $estimatedDays,
    ) {}
}
