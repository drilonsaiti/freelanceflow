<?php

namespace Auth;

use App\Domain\Identity\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a new user and returns token', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
                'token',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                ]
            ]
        );

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com'
    ]);
});
it('registers user with client role',function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'John Doe client',
        'email' => 'john@client.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'role' => UserRole::Client,
    ]);

    $response->assertStatus(201)
    ->assertJsonStructure([
        'token',
        'data' => [
            'id',
            'name',
            'email',
            'role',
            'created_at',
        ]
    ])
    ->assertJsonFragment([
        'role' => UserRole::Client->label(),
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'john@client.com'
    ]);
});
it('fails registration with duplicate email',function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertStatus(201);

    $response2 = $this->postJson('api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response2
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('fails registration with weak password',function () {
    $response = $this->postJson('api/v1/auth/register',[
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'weak',
        'password_confirmation' => 'weak',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});
it('logs in with valid credentials',function () {
    $responseRegister = $this->postJson('api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $responseRegister->assertStatus(201);

    $responseLogin = $this->postJson('api/v1/auth/login',[
       'email' => 'john@example.com',
       'password' => 'Password123!',
    ]);

    $responseLogin->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
            ]
        ]);

    expect($responseLogin->json('token'))->not->toBeEmpty();
});
it('fails login with wrong password',function () {
    $responseRegister = $this->postJson('api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $responseRegister->assertStatus(201);

    $responseLogin = $this->postJson('api/v1/auth/login',[
        'email' => 'john@example.com',
        'password' => 'Password1!',
    ]);

    $responseLogin
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Invalid credentials provided',
        ]);

});
it('fails login with nonexistent email',function () {
    $responseRegister = $this->postJson('api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $responseRegister->assertStatus(201);

    $responseLogin = $this->postJson('api/v1/auth/login',[
        'email' => 'john-no-exsit@example.com',
        'password' => 'Password123!',
    ]);

    $responseLogin
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Invalid credentials provided',
        ]);
});
it('logs out authenticated user',function () {
    $registerResponse = $this->postJson('api/v1/auth/register',[
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $token = $registerResponse->json('token');

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('api/v1/auth/logout');

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Logged out successfully',
        ]);
});
it('cannot logout without token', function () {

    $response = $this->postJson('api/v1/auth/logout');

    $response->assertStatus(401);
});

it('blocks login after 5 failed attempts', function () {

    $this->postJson('/api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ])->assertCreated();

    for ($i = 1; $i <= 4; $i++) {
        $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'WrongPassword123!',
        ])->assertStatus(401);
    }

    $this->postJson('/api/v1/auth/login', [
        'email' => 'john@example.com',
        'password' => 'WrongPassword123!',
    ])
        ->assertStatus(429)
        ->assertJsonStructure([
            'message',
        ]);
});

it('allows requests within rate limit', function () {
    $this->postJson('/api/v1/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ])->assertCreated();

    for ($i = 1; $i <= 4; $i++) {
        $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'WrongPassword123!',
        ])->assertStatus(401);
    }
});
