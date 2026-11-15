<?php

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;

beforeEach(function () {
    $throttleKey = Str::transliterate(Str::lower('john@gmail.com') . '|' . '127.0.0.1');
    RateLimiter::clear($throttleKey);

    User::factory()->create([
        'email' => 'john@gmail.com',
        'password' => 'P@ssw0rd123'
    ]);
});

test('customers can login with valid credentials', function () {
    $this->postJson('/api/v1/auth/login', [
        'email' => 'john@gmail.com',
        'password' => 'P@ssw0rd123'
    ])->assertStatus(200)->assertJsonStructure([
        'data' => [
            'id', 'name', 'email',
            'token',
        ],
        'message'
    ]);
});

test('customers cant login with wrong password', function () {
    $this->postJson('/api/v1/auth/login', [
        'email' => 'john@gmail.com',
        'password' => 'WrongP@ssword123'
    ])->assertStatus(422)->assertJsonValidationErrors(['email']);
});

test('customers will get rate-limited after too many login attempts', function () {
    for ($i = 1; $i <= 5; $i++) {
        $this->postJson('/api/v1/auth/login', [
            'email' => 'john@gmail.com',
            'password' => 'WrongP@ssword123'
        ])->assertStatus(422);
    }

    $this->postJson('/api/v1/auth/login', [
        'email' => 'john@gmail.com',
        'password' => 'P@ssw0rd123'
    ])->assertStatus(429);
});