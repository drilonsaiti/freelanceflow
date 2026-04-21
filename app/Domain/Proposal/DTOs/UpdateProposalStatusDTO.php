<?php

namespace App\Domain\Proposal\DTOs;

use App\Domain\Proposal\Enums\ProposalStatus;
use Spatie\LaravelData\Data;

final class UpdateProposalStatusDTO extends Data
{

    public function __construct(
        public readonly int $proposalId,
        public readonly int $projectId,
        public readonly ProposalStatus $status,
    ) {}

}
