<?php

namespace App\Domain\Proposal\DTOs;

final class AcceptProposalDTO
{
    public function __construct(
        public readonly int $proposalId,
        public readonly int $projectId,
    ) {}
}
