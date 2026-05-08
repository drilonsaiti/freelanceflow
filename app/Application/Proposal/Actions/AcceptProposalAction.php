<?php

namespace App\Application\Proposal\Actions;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Exceptions\InvalidProjectTransitionException;
use App\Domain\Proposal\DTOs\AcceptProposalDTO;
use App\Domain\Proposal\Enums\ProposalStatus;
use App\Domain\Proposal\Events\ProposalAccepted;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class AcceptProposalAction
{

    public function execute(AcceptProposalDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $proposal = Proposal::findOrFail($dto->proposalId);

            if ($proposal->status !== ProposalStatus::Pending) {
                throw ValidationException::withMessages([
                    'proposal' => 'Only pending proposals can be accepted.',
                ]);
            }

            $project = Project::query()
                ->where('id', $proposal->project_id)
                ->firstOrFail();

            if (!$project->status->canTransitionTo(ProjectStatus::InProgress)) {
                throw new InvalidProjectTransitionException();
            }

            $proposal->update(['status' => ProposalStatus::Accepted]);

            Proposal::where('project_id', $dto->projectId)
                ->whereNot('id', $proposal->id)
                ->update(['status' => ProposalStatus::Rejected]);


            $project->update([
                'status' => ProjectStatus::InProgress
            ]);
            event(new ProposalAccepted($proposal));
        });
    }
}
