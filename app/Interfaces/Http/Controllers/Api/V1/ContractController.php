<?php

namespace App\Interfaces\Http\Controllers\Api\V1;

use App\Domain\Identity\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Interfaces\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContractController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny',Contract::class);

        $user = auth()->user();

        $contracts = match($user->role){
            UserRole::Freelancer => Contract::forFreelancer($user->id)
                ->with(['project','client','freelancer','proposal'])
                ->get(),
            UserRole::Client     => Contract::forClient($user->id)
                ->with(['project','client','freelancer','proposal'])
                ->get(),
            default              => collect(),
        };

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
