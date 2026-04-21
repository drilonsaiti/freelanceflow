<?php

namespace App\Application\Proposal\Actions;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Proposal\DTOs\CreateProposalDTO;
use App\Domain\Proposal\Enums\ProposalStatus;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class SubmitProposalAction
{

    public function execute(CreateProposalDTO $dto): Proposal
    {
        $project = Project::findOrFail($dto->projectId);

        if ($project->status !== ProjectStatus::Open) {
            throw ValidationException::withMessages([
                'project' => 'You can only submit proposals to open projects.',
            ]);
        }


        $exists = Proposal::query()->where('project_id', $dto->projectId)->where('freelancer_id', $dto->freelancerId)->exists();

        if ($exists){
            throw ValidationException::withMessages([
                'proposal' => 'You have already submitted a proposal for this project.',
            ]);
        }

        $ulid = (string) Str::ulid();

        return Proposal::create([
            'ulid' => $ulid,
            'project_id' => $dto->projectId,
            'freelancer_id' => $dto->freelancerId,
            'cover_letter' => $dto?->coverLetter,
            'proposed_rate' => $dto?->proposedRate,
            'estimated_days' => $dto?->estimatedDays,
            'status' => ProposalStatus::Pending,
            'client_note' => $dto?->clientNote,
        ]);
    }
}
