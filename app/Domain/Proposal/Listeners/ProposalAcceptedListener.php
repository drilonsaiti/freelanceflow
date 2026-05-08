<?php

namespace App\Domain\Proposal\Listeners;

use App\Application\Contract\Actions\CreateContractAction;
use App\Domain\Contract\DTOs\CreateContractDTO;
use App\Domain\Contract\Enums\RateType;
use App\Domain\Proposal\DTOs\AcceptProposalDTO;
use Log;

class ProposalAcceptedListener
{

    public function __construct(private readonly CreateContractAction $createContract){}

    public function handle(\App\Domain\Proposal\Events\ProposalAccepted $event): void
    {
        $dto = new CreateContractDTO(
            $event->proposal->project_id,
            $event->proposal->freelancer_id,
            auth()->id(),
            $event->proposal->id,
            $event->proposal->project->title,
            $event->proposal->proposed_rate,
            RateType::Hourly,
            $event->proposal->estimated_days,
        );
        $this->createContract->execute($dto);
    }

}
