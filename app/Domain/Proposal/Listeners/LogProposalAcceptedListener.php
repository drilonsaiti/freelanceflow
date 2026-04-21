<?php

namespace App\Domain\Proposal\Listeners;

use Illuminate\Support\Facades\Log;

class LogProposalAcceptedListener
{

    public function handle(\App\Domain\Proposal\Events\ProposalAccepted $event): void
    {
        Log::info('Proposal accepted', [
            'proposal_id' => $event->proposal->id,
            'freelancer_id' => $event->proposal->freelancer_id ?? null,
        ]);
    }

}
