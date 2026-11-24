<?php

declare(strict_types=1);

namespace Modules\Wallet\Enums;

enum Currency: string
{
    case EGP = 'EGP';
    case USD = 'USD';
    case EUR = 'EUR';
    case SAR = 'SAR';

    public const DEFAULT = self::EGP;
}
