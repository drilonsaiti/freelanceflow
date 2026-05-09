<?php

namespace App\Domain\Contract\Events;

use App\Models\Contract;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ContractStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(public Contract $contract){}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("contracts.{$this->contract->ulid}")
        ];
    }

    public function broadcastAs(): string
    {
        return 'contract.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->contract->status->value,
            'label' => $this->contract->status->label(),
        ];
    }

}
