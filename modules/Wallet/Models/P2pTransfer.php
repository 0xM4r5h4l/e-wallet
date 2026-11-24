<?php

declare(strict_types=1);

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Database\Factories\P2pTransferFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UseFactory(P2pTransferFactory::class)]
class P2pTransfer extends Model
{
    /** @use HasFactory<P2pTransferFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'from_wallet_id',
        'to_wallet_id',
        'amount',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'amount' => 'integer',
        'completed_at' => 'datetime'
    ];

    public function fromWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['from_wallet_id', 'to_wallet_id', 'amount', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "A new p2p transfer has been created.",
                    'updated' => "A p2p transfer has been updated.",
                    'deleted' => "A p2p transfer has been deleted.",
                    default => "An event has occurred.",
                };
            });
    }
}

