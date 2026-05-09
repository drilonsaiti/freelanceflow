<?php

namespace App\Domain\Contract\Observers;

use App\Domain\Contract\Events\ContractStatusUpdated;
use App\Domain\Contract\Jobs\SendContractCreatedNotification;
use App\Models\ActivityLog;
use App\Models\Contract;
use Illuminate\Support\Facades\Cache;

class ContractObserver
{

    public function created(Contract $contract): void
    {
        ActivityLog::create([
            'ulid'         => (string) \Illuminate\Support\Str::ulid(),
            'subject_type' => Contract::class,
            'subject_id'   => $contract->id,
            'event' => 'created'
        ]);

        SendContractCreatedNotification::dispatch($contract);
        $this->clearCache($contract->freelancer_id,$contract->client_id);

    }

    public function updated(Contract $contract): void {

        if ($contract->isDirty('status')) {
            ActivityLog::create([
                'ulid'         => (string) \Illuminate\Support\Str::ulid(),
                'subject_type' => Contract::class,
                'subject_id'   => $contract->id,
                'event'        => 'status_changed',
                'properties'   => [
                    'old_status' => $contract->getOriginal('status'),
                    'new_status' => $contract->status->value,
                ],
            ]);

            event(new ContractStatusUpdated($contract));

            $this->clearCache($contract->freelancer_id,$contract->client_id);
        }
    }

    private function clearCache(int $freelancer_id,int $client_id): void {
        Cache::forget("contracts.user.{$freelancer_id}");
        Cache::forget("contracts.user.{$client_id}");
    }

}
