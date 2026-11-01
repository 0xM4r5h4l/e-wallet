<?php

namespace Modules\Payout\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payout\Database\Factories\WithdrawalFactory;

#[UseFactory(WithdrawalFactory::class)]
class Withdrawal extends Model
{
    /** @use HasFactory<WithdrawalFactory> */
    use HasFactory;
}

