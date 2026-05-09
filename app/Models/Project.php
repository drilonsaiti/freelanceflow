<?php

namespace App\Models;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Enums\ProjectVisibility;
use App\Domain\Project\Observer\ProjectObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

#[ObservedBy([ProjectObserver::class])]
class Project extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'ulid',
        'client_id',
        'title',
        'description',
        'budget_min',
        'budget_max',
        'required_skills',
        'status',
        'visibility',
        'category',
        'deadline',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
        'visibility' => ProjectVisibility::class,
        'required_skills' => 'array',
        'deadline' => 'date'
    ];


    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function scopeOpen(Builder $query)
    {
        return $query->where('status', ProjectStatus::Open)
            ->where('visibility', ProjectVisibility::Public);
    }

    public function scopeForClient(Builder $query,int $clientId)
    {
        return $query
            ->where('client_id', $clientId);
    }

    public function scopeWithBudgetRange(Builder $query,int $min, int $max)
    {
        return $query
            ->where('budget_min',">=",$min)
            ->where('budget_max',"<=",$max);
    }

    public function getRouteKeyName()
    {
        return 'ulid';
    }
}
