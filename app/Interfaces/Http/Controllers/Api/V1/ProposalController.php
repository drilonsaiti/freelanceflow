<?php

namespace App\Interfaces\Http\Controllers\Api\V1;

use App\Application\Proposal\Actions\AcceptProposalAction;
use App\Application\Proposal\Actions\SubmitProposalAction;
use App\Application\Proposal\Actions\WithdrawProposalAction;
use App\Domain\Proposal\DTOs\AcceptProposalDTO;
use App\Domain\Proposal\DTOs\CreateProposalDTO;
use App\Domain\Proposal\DTOs\UpdateProposalStatusDTO;
use App\Interfaces\Http\Requests\SubmitProposalRequest;
use App\Interfaces\Http\Resources\ProposalResource;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class ProposalController
{

    use AuthorizesRequests;

    public function index(Project $project)
    {
        $this->authorize('viewAny', [Proposal::class, $project]);

        $proposals = $project->proposals()->with('freelancer')->get();

        return response()->json([
            'data' => ProposalResource::collection($proposals),
            'message' => 'Proposals retrieved successfully'
        ]);
    }

    public function myProposals(Project $project)
    {
        $this->authorize('viewMine', [Proposal::class, $project]);

        $proposals = $project->proposals()->forFreelancer()->get();

        return response()->json([
            'data' => ProposalResource::collection($proposals),
            'message' => 'Proposals retrieved successfully'
        ]);
    }

    public function show(Project $project, Proposal $proposal)
    {
        $this->authorize('view', [Proposal::class, $project, $proposal]);

        return response()->json([
            'data' => ProposalResource::make($proposal),
            'message' => 'Proposal retrieved successfully'
        ]);
    }

    public function store(SubmitProposalRequest $request, Project $project, SubmitProposalAction $submitProposalAction)
    {
        $this->authorize('create', [Proposal::class, $project]);

        $result = $submitProposalAction->execute(CreateProposalDTO::from([
            ...$request->validated(),
            'projectId' => $project->id,
            'freelancerId' => $request->user()->id,
        ]));

        return response()->json([
            'data' => ProposalResource::make($result),
            'message' => 'Proposal submitted successfully'
        ], 201);
    }

    public function accept(
        Project              $project,
        Proposal             $proposal,
        AcceptProposalAction $acceptProposalAction
    ): JsonResponse
    {
        $this->authorize('accept', $proposal);

        $acceptProposalAction->execute(new AcceptProposalDTO(
            proposalId: $proposal->id,
            projectId: $project->id,
        ));

        return response()->json(['message' => 'Proposal accepted successfully']);
    }

    public function withdraw(Project $project, Proposal $proposal,WithdrawProposalAction $withdrawProposalAction)
    {
        $this->authorize('withdraw', [Proposal::class, $project, $proposal]);

        $withdrawProposalAction->execute($proposal);

        return response()->json(['message' => 'Proposal withdrawn successfully']);

    }

}
