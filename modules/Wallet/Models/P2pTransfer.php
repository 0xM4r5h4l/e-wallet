<?php

declare(strict_types=1);

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Database\Factories\P2pTransferFactory;

#[UseFactory(P2pTransferFactory::class)]
class P2pTransfer extends Model
{
    /** @use HasFactory<P2pTransferFactory> */
    use HasFactory;
}

