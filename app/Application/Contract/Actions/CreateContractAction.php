<?php

namespace App\Application\Contract\Actions;

use App\Domain\Contract\DTOs\CreateContractDTO;
use App\Models\Contract;

final class CreateContractAction
{
    public function execute(CreateContractDTO $dto): Contract{
        return Contract::create([
            'ulid' => (string) \Illuminate\Support\Str::ulid(),
            'project_id' => $dto->projectId,
            'freelancer_id' => $dto->freelancerId,
            'client_id' => $dto->clientId,
            'proposal_id' => $dto->proposalId,
            'title' => $dto->title,
            'description' => $dto->description ?? '',
            'rate' => $dto->rate,
            'rate_type' => $dto->rateType,
            'estimated_days' => $dto->estimatedDays,
        ]);

    }
}
