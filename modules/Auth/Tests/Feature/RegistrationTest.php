<?php

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;

beforeEach(function () {
    $throttleKey = Str::transliterate(Str::lower('john@gmail.com') . '|' . '127.0.0.1');
    RateLimiter::clear($throttleKey);
});

test('new customers can register with valid information', function () {
    $this->postJson('/api/v1/auth/register', [
        "name" => "John Doe",
        "email" => "john@gmail.com",
        "password" => "P@ssw0rd123",
        "mobile_number" => "+201095648281"
    ])->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'email',
            'mobile_number',
            'token'
        ],
        'message'
    ])->assertJson([
        'data' => [
            "name" => "John Doe",
            "email" => "john@gmail.com",
            "mobile_number" => "+201095648281"
        ],
        'message' => 'Registration successful'
    ])->assertDatabaseHas('wallets', [
        'currency' => 'EGP',
        'balance' => 0
    ])->assertStatus(201);
});

test('new customers cant register with duplicate email', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@gmail.com',
        'password' => 'P@ssw0rd123123',
        'mobile_number' => '+201024448233'
    ]);

    $this->postJson('/api/v1/auth/register', [
        "name" => $user->name,
        "email" => $user->email,
        "password" => $user->password,
        "mobile_number" => $user->mobile_number
    ])->assertJsonValidationErrors(['email']);
});

test('new customers cant register with duplicate mobile_number', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'jdoe123@gmail.com',
        'password' => 'P@ssw0rd123123',
        'mobile_number' => '+201095648281'
    ]);

    $this->postJson('/api/v1/auth/register', [
        "name" => $user->name,
        "email" => 'john@gmail.com',
        "password" => $user->password,
        "mobile_number" => $user->mobile_number
    ])->assertJsonValidationErrors(['mobile_number']);
});

test('new customers cant register with invalid name', function () {
    $this->postJson('/api/v1/auth/register', [
        "name" => "John S'' Doe",
        "email" => "john@gmail.com",
        "password" => "P@ssw0rd123",
        "mobile_number" => "+201095648281"
    ])->assertJsonValidationErrors(['name']);
});

test('new customers cant register with invalid email', function () {
    $this->postJson('/api/v1/auth/register', [
        "name" => "John Doe",
        "email" => "johngmail.com",
        "password" => "P@ssw0rd123",
        "mobile_number" => "+201095648281"
    ])->assertJsonValidationErrors(['email']);
});

test('mobile number is normalized to E164 format upon registration', function () {
    $this->postJson('/api/v1/auth/register', [
        "name" => "John Doe",
        "email" => "john@gmail.com",
        "password" => "P@ssw0rd123",
        "mobile_number" => "01095648281"
    ])->assertJson([
        'data' => [
            "name" => "John Doe",
            "email" => "john@gmail.com",
            "mobile_number" => "+201095648281"
        ],
        'message' => 'Registration successful'
    ])->assertStatus(201);

    $this->assertDatabaseHas('users', [
        "email" => "john@gmail.com",
        "mobile_number" => "+201095648281"
    ]);
});

test('new customers cant register with weak password', function () {
    $this->postJson('/api/v1/auth/register', [
        "name" => "John Doe",
        "email" => "john@gmail.com",
        "password" => "123456",
        "mobile_number" => "+201095648281"
    ])->assertJsonValidationErrors(['password']);
});