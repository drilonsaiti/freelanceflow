<?php

namespace App\Application\Proposal\Actions;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Proposal\DTOs\AcceptProposalDTO;
use App\Domain\Proposal\Enums\ProposalStatus;
use App\Domain\Proposal\Events\ProposalAccepted;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;

final class AcceptProposalAction
{

    public function execute(AcceptProposalDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $proposal = Proposal::where('id', $dto->proposalId)
                ->pending()
                ->firstOrFail();

            $proposal->update(['status' => ProposalStatus::Accepted]);

            Proposal::where('project_id', $dto->projectId)
                ->whereNot('id', $proposal->id)
                ->update(['status' => ProposalStatus::Rejected]);

            Project::where('id', $dto->projectId)->update(['status' => ProjectStatus::InProgress]);

            event(new ProposalAccepted($proposal));
        });
    }
}
