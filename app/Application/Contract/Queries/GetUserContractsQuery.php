<?php

namespace App\Application\Contract\Queries;

use App\Domain\Identity\Enums\UserRole;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class GetUserContractsQuery
{
    public function handle(User $user): Collection
    {
        $cacheKey = "contracts.user.{$user->id}";

        return Cache::flexible($cacheKey, [300,600], function () use ($user) {
            return match ($user->role) {
                UserRole::Freelancer => Contract::forFreelancer($user->id)
                    ->with(['project:id,title,ulid', 'client:id,name'])
                    ->get(),
                UserRole::Client => Contract::forClient($user->id)
                    ->with(['project:id,title,ulid', 'freelancer:id,name'])
                    ->get(),
                default => collect(),
            };
        });
    }

}
