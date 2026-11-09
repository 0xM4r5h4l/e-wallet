<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Resources\LoginResource;
use Modules\Auth\Http\Resources\RegisterResource;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Auth\Services\RegistrationService;
use Modules\Auth\Services\SessionService;

class AuthController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return (new UserResource($request->user()))
            ->additional([
                'message' => 'User data retrieved.'
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function register(RegisterRequest $request, RegistrationService $registrationService): JsonResponse
    {
        $result = $registrationService->register($request->validated());

        return (new RegisterResource($result))
            ->additional([
                'message' => 'Registration successful',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function login(LoginRequest $request, SessionService $sessionService): JsonResponse
    {
        $result = $sessionService->login($request->validated());

        return (new LoginResource($result))
            ->additional([
                'message' => 'Login successful'
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function logout(Request $request, SessionService $sessionService): JsonResponse
    {
        $sessionService->logout($request->user());

        return response()->json([
            'message' => 'Logout successful',
        ])->setStatusCode(200);
    }
}
