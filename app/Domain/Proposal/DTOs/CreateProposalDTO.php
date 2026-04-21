<?php

namespace App\Domain\Proposal\DTOs;

use App\Domain\Proposal\Enums\ProposalStatus;
use Spatie\LaravelData\Data;

final class CreateProposalDTO extends Data
{
    public function __construct(
        public readonly int $projectId,
        public readonly int $freelancerId,
        public readonly string $coverLetter,
        public readonly float $proposedRate,
        public readonly int $estimatedDays,
        public readonly ProposalStatus $status,
        public readonly ?string $clientNote,
    ){}

}
