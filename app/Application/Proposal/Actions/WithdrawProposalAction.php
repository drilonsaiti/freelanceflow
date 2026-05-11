<?php

namespace App\Application\Proposal\Actions;

use App\Domain\Proposal\Enums\ProposalStatus;
use App\Models\Proposal;
use Illuminate\Validation\ValidationException;

final class WithdrawProposalAction
{
    public function execute(Proposal $proposal): void
    {
        if ($proposal->status !== ProposalStatus::Pending) {
            throw ValidationException::withMessages([
                'proposal' => 'Only pending proposals can be accepted.',
            ]);
        }

        $proposal->update(['status' => ProposalStatus::Withdrawn]);
    }
}
