<?php

namespace App\Application\Identity\Actions;

use App\Domain\Identity\DTOs\AuthResultDTO;
use App\Domain\Identity\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class LoginUserAction
{

    public function execute(array $credentials): AuthResultDTO
    {
        $user = User::query()
            ->where('email', mb_strtolower($credentials['email']))
            ->first();

        if(!$user || !Hash::check($credentials['password'],$user->getAuthPassword())){
            throw new InvalidCredentialsException();
        }

        $token = $user->createToken('api')->plainTextToken;

        return new AuthResultDTO(user: $user,token: $token);
    }
}
