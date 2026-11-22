<?php

declare(strict_types=1);

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Wallet\Database\Factories\WalletFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\Auth\Models\User;

class Wallet extends Model
{
    /** @use HasFactory<WalletFactory> */
    use HasFactory, LogsActivity, HasUuids;

    protected $fillable = [
        'user_id',
        'currency',
        'status',
    ];

    protected $casts = [
        'balance' => 'integer'
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionLedgers(): HasMany
    {
        return $this->hasMany(TransactionLedger::class);
    }

    public function walletLimits(): HasMany
    {
        return $this->hasMany(WalletLimit::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'currency', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "A new wallet has been created.",
                    'updated' => "A wallet has been updated.",
                    'deleted' => "A wallet has been deleted.",
                    default => "An event has occurred.",
                };
            });
    }

}

