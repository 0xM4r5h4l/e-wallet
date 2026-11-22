<?php

declare(strict_types=1);

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Database\Factories\WalletLimitFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class WalletLimit extends Model
{
    /** @use HasFactory<WalletLimitFactory> */
    use HasFactory, LogsActivity;

    protected $fillable = [
        'limit_type',
        'limit_value',
        'current_usage',
        'reset_at'
    ];

    protected $casts = [
        'reset_at' => 'datetime',
        'limit_value' => 'integer',
        'current_usage' => 'integer'
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['wallet_id', 'limit_type', 'limit_value', 'current_usage', 'reset_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "A new wallet limit has been created.",
                    'updated' => "A wallet limit has been updated.",
                    'deleted' => "A wallet limit has been deleted.",
                    default => "An event has occurred.",
                };
            });
    }
}

