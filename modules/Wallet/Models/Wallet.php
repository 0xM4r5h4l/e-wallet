<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Database\Factories\WalletFactory;

#[UseFactory(WalletFactory::class)]
class Wallet extends Model
{
    /** @use HasFactory<WalletFactory> */
    use HasFactory;
}

