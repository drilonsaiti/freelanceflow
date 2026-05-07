<?php

namespace App\Domain\Contract\Jobs;

use App\Infrastructure\Mail\ContractCreatedClientMail;
use App\Infrastructure\Mail\ContractCreatedFreelancerMail;
use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContractCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Contract $contract
    ) {}

    public function handle(): void
    {
        // Mail to freelancer
        Mail::to($this->contract->freelancer->email)->send(
            new ContractCreatedFreelancerMail($this->contract)
        );

        // Mail to client
        Mail::to($this->contract->client->email)->send(
            new ContractCreatedClientMail($this->contract)
        );
    }
}
