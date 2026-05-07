<?php

namespace App\Domain\Contract\Observers;

use App\Domain\Contract\Jobs\SendContractCreatedNotification;
use App\Models\ActivityLog;
use App\Models\Contract;

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

    }

    public function updated(Contract $contract): void {

        if ($contract->isDirty('status')) {
            ActivityLog::create([
                'ulid'         => (string) \Illuminate\Support\Str::ulid(),
                'subject_type' => Contract::class,
                'subject_id'   => $contract->id,
                'event'        => 'status_changed',
                'properties'   => json_encode([
                    'old_status' => $contract->getOriginal('status'),
                    'new_status' => $contract->status->value,
                ]),
            ]);
        }
    }

}
