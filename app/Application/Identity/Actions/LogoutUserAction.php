<?php

namespace App\Application\Identity\Actions;

use App\Models\User;

final class LogoutUserAction
{

    public function execute(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function logoutFromAllDevices(User $user): void
    {
        $user->tokens()->delete();
    }

}
