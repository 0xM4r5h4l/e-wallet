<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Modules\Auth\Events\UserRegistered;
use Modules\Auth\Models\User;

class RegistrationService
{
    public function register(array $validated): array
    {
        $user = User::create($validated);
        
        $expiresAt = now()->plus(minutes: config('module_auth.token_duration_minutes', 15));

        $token = $user->createToken('auth_token', expiresAt: $expiresAt)->plainTextToken;
        
        UserRegistered::dispatch($user->id);
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}


