<?php

namespace App\Interfaces\Http\Controllers\Api\V1\Auth;

use App\Application\Identity\Actions\LoginUserAction;
use App\Application\Identity\Actions\LogoutUserAction;
use App\Application\Identity\Actions\RegisterUserAction;
use App\Domain\Identity\DTOs\RegisterUserDTO;
use App\Interfaces\Http\Requests\LoginRequest;
use App\Interfaces\Http\Requests\RegisterRequest;
use App\Interfaces\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AuthController
{

    public function register(RegisterRequest $request,RegisterUserAction $registerUser): JsonResponse {

        $result = $registerUser->execute(RegisterUserDTO::from($request->validated()));

        return response()->json([
            'token' => $result->token,
            'data' => new UserResource($result->user),
            'message' => 'User registered successfully'
        ],201);
    }

    public function login(LoginRequest $request,LoginUserAction $loginUser): JsonResponse {
        $result = $loginUser->execute($request->validated());

        return response()->json([
            'token' => $result->token,
            'data' => new UserResource($result->user),
            'message' => 'User logged in successfully'
        ]);
    }

    public function logout(Request $request, LogoutUserAction $logoutUser): JsonResponse {
        $logoutUser->execute($request->user());

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
