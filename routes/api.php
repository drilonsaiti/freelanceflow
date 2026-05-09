<?php

use App\Interfaces\Http\Controllers\Api\V1\Auth\AuthController;
use App\Interfaces\Http\Controllers\Api\V1\ContractController;
use App\Interfaces\Http\Controllers\Api\V1\ProjectController;
use App\Interfaces\Http\Controllers\Api\V1\ProposalController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware(['throttle:auth'])->group(function () {
        Route::post('auth/register', [AuthController::class, 'register'])->name('api.v1.auth.register');
        Route::post('auth/login', [AuthController::class, 'login'])->name('api.v1.auth.login');

    });
    Route::middleware(['auth:sanctum','throttle:api'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('api.v1.auth.logout');

        /** Projects */
        Route::get('projects', [ProjectController::class, 'index'])
            ->name('api.v1.projects.index');
        Route::post('projects', [ProjectController::class, 'store'])
            ->name('api.v1.projects.store');
        Route::get('projects/{project:ulid}', [ProjectController::class, 'show'])
            ->name('api.v1.projects.show');

        /** Proposals */
        Route::get('projects/{project:ulid}/proposals', [ProposalController::class, 'index'])
            ->name('api.v1.projects.proposals.index');
        Route::post('projects/{project:ulid}/proposals', [ProposalController::class, 'store'])
            ->name('api.v1.projects.proposals.store');
        Route::patch('projects/{project:ulid}/proposals/{proposal:ulid}/accept', [ProposalController::class, 'accept'])
            ->name('api.v1.projects.proposals.accept');
        Route::get('projects/{project:ulid}/my-proposals', [ProposalController::class, 'myProposals']);

        /** Contracts */
        Route::get('contracts', [ContractController::class, 'index'])
            ->name('api.v1.contracts.index');
        Route::get('contracts/{contract:ulid}', [ContractController::class, 'show'])
            ->name('api.v1.contracts.show');
    });
});
