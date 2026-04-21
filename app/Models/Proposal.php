<?php

namespace App\Models;

use App\Domain\Proposal\Enums\ProposalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class Proposal extends Model
{
    //

    protected $casts = [
        'status' => ProposalStatus::class,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', ProposalStatus::Pending);
    }

    public function scopeForFreelancer(Builder $query,int $freelancerId)
    {
        return $query->where('freelancer_id', $freelancerId);
    }

    public function getRouteKeyName()
    {
        return 'ulid';
    }
}
