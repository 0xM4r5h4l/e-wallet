<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\WalletController;

Route::prefix('wallets')->middleware('auth:sanctum')->group(function () {
    Route::get('', [WalletController::class, 'index']);
    Route::post('', [WalletController::class, 'store']);
    Route::get('{wallet}', [WalletController::class, 'show']);
});