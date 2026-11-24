<?php

declare(strict_types=1);

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Database\Factories\TransactionLedgerFactory;
use Modules\Wallet\Enums\TransactionDirection;
use Modules\Wallet\Enums\TransactionStatus;
use Modules\Wallet\Enums\TransactionType;

#[UseFactory(TransactionLedgerFactory::class)]
class TransactionLedger extends Model
{
    /** @use HasFactory<TransactionLedgerFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'wallet_id',
        'transaction_id',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'direction',
        'reference_id',
        'status'
    ];

    protected $casts = [
        'amount' => 'integer',
        'balance_before' => 'integer',
        'balance_after' => 'integer',
        'direction' => TransactionDirection::class,
        'status' => TransactionStatus::class,
        'transaction_type' => TransactionType::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}

