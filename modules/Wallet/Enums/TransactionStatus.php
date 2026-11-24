<?php

declare(strict_types=1);

namespace Modules\Wallet\Enums;

enum TransactionStatus: string
{
    case Pending = 'PENDING';
    case Success = 'SUCCESS';
    case Failed = 'FAILED';
}
