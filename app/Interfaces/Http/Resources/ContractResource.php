<?php

namespace App\Interfaces\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->ulid,
            'project' => [
                'title' => $this->project->title,
                'description' => $this->project->description,
            ],
            'freelancer' => [
                'id' => $this->freelancer?->id,
                'name' => $this->freelancer?->name,
            ],
            'client' => [
                'id' => $this->client?->id,
                'name' => $this->client?->name,
            ],
            'proposal' => [
                'id' => $this->proposal->id,
                'client_note' => $this->proposal?->client_note,
            ],
            'title' => $this->title,
            'description' => $this->description,
            'rate' => $this->rate,
            'rate_type'  => [
                'value' => $this->rate_type->value,
                'label' => $this->rate_type->label(),
            ],
            'start_date' => $this?->start_date,
            'end_date' => $this?->end_date,
            'status'     => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],            'terms' => $this->terms,
            'created_at' => $this->created_at->toISOString(),
        ];
    }

}
