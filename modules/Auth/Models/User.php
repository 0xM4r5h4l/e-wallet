<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\Auth\Database\Factories\UserFactory;

class User extends Authenticatable
{
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::orderedUuid();
        });
    }

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'mobile_number_verified_at',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_number_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'email_verified_at', 'mobile_number_verified_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "A new user has been created.",
                    'updated' => "A user has been updated.",
                    'deleted' => "A user has been deleted.",
                    default => "An event has occurred.",
                };
            });
    }
}
