<?php

use Modules\Auth\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('deletes the token from database when customer logout', function () {
    $token = $this->user->createToken('auth_token')->plainTextToken;

    $this->withToken($token)
        ->postJson('/api/v1/auth/logout')
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Logout successful'
        ]);
    
    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $this->user->id,
    ]);
});

it('denies access for unauthenticated requests', function () {
    $wrongToken = '8|KvjfS8n852M63DVXqGUYiSiVKlJLdLo6wszLZzIqbae18292';

    $this->withToken($wrongToken)
        ->post('/api/v1/auth/logout')
        ->assertJson([
            'message' => 'Unauthenticated'
        ]);
});