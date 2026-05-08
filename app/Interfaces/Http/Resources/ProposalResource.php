<?php

namespace App\Interfaces\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProposalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ulid,

            'project_id' => $this->project?->ulid,

            'freelancer' => [
                'id' => $this->freelancer?->id,
                'name' => $this->freelancer?->name,
            ],

            'cover_letter' => $this->cover_letter,

            'proposed_rate' => $this->proposed_rate,
            'estimated_days' => $this->estimated_days,

            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],

            'client_note' => $this->client_note,

            'created_at' => $this->created_at?->toISOString(),
        ];
    }

}
