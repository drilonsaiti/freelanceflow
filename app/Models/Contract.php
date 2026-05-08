<?php

namespace App\Models;

use App\Domain\Contract\Enums\ContractStatus;
use App\Domain\Contract\Enums\RateType;
use App\Domain\Contract\Observers\ContractObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ContractObserver::class])]
class Contract extends Model
{
    use HasFactory;
    protected $fillable = [
        'ulid',
        'client_id',
        'freelancer_id',
        'project_id',
        'proposal_id',
        'status',
        'rate_type',
        'rate',
        'start_date',
        'title',
        'description',
        'estimated_days',
    ];
    protected $casts = [
        'status' => ContractStatus::class,
        'rate_type' => RateType::class,
    ];


    public function project(): BelongsTo{
        return $this->belongsTo(Project::class);
    }

    public function freelancer(): BelongsTo{
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function client(): BelongsTo{
        return $this->belongsTo(User::class, 'client_id');
    }

    public function proposal(): BelongsTo{
        return $this->belongsTo(Proposal::class);
    }

    public function activities(): HasMany{
        return $this->hasMany(ActivityLog::class,'subject_id','id');
    }
    public function scopeActive(Builder $query){
        return $query->where('status', ContractStatus::Active);
    }

    public function scopeForFreelancer(Builder $query,int $freelancerId){
        return $query->where('freelancer_id', $freelancerId);
    }

    public function scopeForClient(Builder $query,int $clientId){
        return $query->where('client_id', $clientId);
    }

    public function getRouteKeyName()
    {
        return 'ulid';
    }
}
