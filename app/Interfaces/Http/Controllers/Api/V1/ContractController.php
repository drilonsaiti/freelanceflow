<?php

namespace App\Interfaces\Http\Controllers\Api\V1;

use App\Application\Contract\Queries\GetUserContractsQuery;
use App\Domain\Identity\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContractController extends Controller
{
    use AuthorizesRequests;

    public function index(GetUserContractsQuery $getUserContractsQuery)
    {
        $this->authorize('viewAny',Contract::class);

        $user = auth()->user();

        $contracts = $getUserContractsQuery->handle($user);

        return response()->json([
            'data' => ContractResource::collection($contracts),
            'message' => 'Contracts retrieved successfully'
        ]);
    }

    public function show(Contract $contract)
    {
        $this->authorize('view', $contract);
        return response()->json([
            'data' => ContractResource::make($contract),
            'message' => 'Contract retrieved successfully'
        ]);
    }
}
