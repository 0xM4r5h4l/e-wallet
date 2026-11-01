<?php

namespace Modules\PaymentProcessing\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PaymentProcessing\Database\Factories\TopUpTransactionFactory;

#[UseFactory(TopUpTransactionFactory::class)]
class TopUpTransaction extends Model
{
    /** @use HasFactory<TopUpTransactionFactory> */
    use HasFactory;
}

