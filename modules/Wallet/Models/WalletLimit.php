<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Database\Factories\WalletLimitFactory;

#[UseFactory(WalletLimitFactory::class)]
class WalletLimit extends Model
{
    /** @use HasFactory<WalletLimitFactory> */
    use HasFactory;
}

