<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class SessionService
{
    public function login(array $loginData): array
    {
        $user = User::where('email', $loginData['email'])->first();

        if (! $user || ! Hash::check($loginData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        $expiresAt = now()->plus(minutes: config('module_auth.token_duration_minutes', 15));
        $token = $user->createToken('auth_token', expiresAt: $expiresAt)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        /** @var PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();
        $token?->delete();
    }
}
