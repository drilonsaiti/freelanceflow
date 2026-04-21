<?php

namespace App\Interfaces\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ulid,

            'title' => $this->title,
            'description' => $this->description,

            'budget' => [
                'min' => $this->budget_min,
                'max' => $this->budget_max,
            ],

            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],

            'visibility' => [
                'value' => $this->visibility->value,
                'label' => $this->visibility->label(),
            ],

            'category' => $this->category,
            'required_skills' => $this->required_skills,

            'deadline' => $this->deadline?->toDateString(),

            'client' => [
                'id' => $this->client?->id,
                'name' => $this->client?->name,
            ],

            'created_at' => $this->created_at?->toISOString(),
        ];
    }


}
