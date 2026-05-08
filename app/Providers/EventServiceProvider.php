<?php

namespace App\Providers;

use App\Domain\Proposal\Events\ProposalAccepted;
use App\Domain\Proposal\Listeners\ProposalAcceptedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProposalAccepted::class => [
            ProposalAcceptedListener::class,
        ],
    ];
}
