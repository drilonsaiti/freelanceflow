<?php

namespace App\Domain\Contract\Policies;

use App\Models\Contract;
use App\Models\User;

class ContractPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Contract $contract): bool
    {
        return $user->id === $contract->freelancer_id ||
            $user->id === $contract->client_id;
    }
}
