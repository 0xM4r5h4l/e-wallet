<?php

declare(strict_types=1);

namespace Modules\Wallet\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Wallet\Http\Requests\StoreWalletRequest;
use Illuminate\Http\Request;
use Modules\Wallet\Models\Wallet;
use Illuminate\Support\Facades\Gate;
use Modules\Wallet\Http\Resources\WalletResource;
use Modules\Wallet\Services\WalletService;

class WalletController extends Controller
{
    public function index(Request $request, WalletService $walletService): JsonResponse
    {
        $result = $walletService->getUserWallets($request->user()->id);
        return WalletResource::collection($result)
            ->additional([
                'message' => 'User wallets list retrieved.'
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function store(StoreWalletRequest $request, WalletService $walletService): JsonResponse
    {
        $validatedData = $request->validated();
        $wallet = $walletService->createWallet($request->user()->id, $validatedData['currency']);

        return (new WalletResource($wallet))
            ->additional([
                'message' => 'Wallet created.'
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Wallet $wallet): JsonResponse
    {
        Gate::authorize('view', $wallet);

        return (new WalletResource($wallet))
            ->additional([
                'message' => 'Wallet data retrieved.'
            ])
            ->response()
            ->setStatusCode(200);
    }


}
