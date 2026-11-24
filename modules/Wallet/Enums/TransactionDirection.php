<?php

declare(strict_types=1);

namespace Modules\Wallet\Enums;

enum TransactionDirection: string
{
    case Debit = 'DEBIT';
    case Credit = 'CREDIT';
}