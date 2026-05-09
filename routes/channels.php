<?php

use App\Models\Contract;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('contracts.{ulid}', function (User $user, string $ulid) {
    $contract = Contract::where('ulid', $ulid)->first();
    return $contract && (
            $user->id === $contract->freelancer_id ||
            $user->id === $contract->client_id
        );
});
