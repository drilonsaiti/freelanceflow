<?php

namespace App\Application\Identity\Actions;

use App\Domain\Identity\DTOs\AuthResultDTO;
use App\Domain\Identity\DTOs\RegisterUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class RegisterUserAction
{

    public function execute(RegisterUserDTO $dto): AuthResultDTO
    {
        $user = User::query()->create([
               'name' => $dto->name,
               'email' => $dto->email,
               'password' => Hash::make($dto->password),
               'role' => $dto->role->value
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return new AuthResultDTO(user: $user,token: $token);
    }
}
