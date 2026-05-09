<?php

namespace App\Providers;

use App\Domain\Contract\Policies\ContractPolicy;
use App\Domain\Project\Policies\ProjectPolicy;
use App\Domain\Proposal\Policies\ProposalPolicy;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Proposal::class, ProposalPolicy::class);
        Gate::policy(Contract::class, ContractPolicy::class);
    }
}
