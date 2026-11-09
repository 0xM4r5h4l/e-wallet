<?php

declare(strict_types=1);

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Database\Factories\WalletLimitFactory;

class WalletLimit extends Model
{
    /** @use HasFactory<WalletLimitFactory> */
    use HasFactory;
}

