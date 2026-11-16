<?php

use Modules\Auth\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('returns profile data for authenticated customers', function () {
    $token = $this->user->createToken('auth_token')->plainTextToken;

    $this->withToken($token)->getJson('/api/v1/auth/me')->assertJsonStructure([
        'data' => [
            'id', 'name', 'email', 'email_verified',
            'mobile_number', 'mobile_number_verified',
            'joined_at'
        ],
        'message'
    ])->assertJson([
        'data' => [
            'email' => $this->user->email,
            'mobile_number' => $this->user->mobile_number,
        ]
    ])->assertStatus(200);
});

it('denies access to unauthenticated requests', function () {
    $wrongToken = '8|KvjfS8n852M63DVXqGUYiSiVKlJLdLo6wszLZzIqbae18292';

    $this->withToken($wrongToken)->getJson('/api/v1/auth/me')->assertJson([
        'message' => 'Unauthenticated'
    ])->assertStatus(401);
});
