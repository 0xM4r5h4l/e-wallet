<?php

declare(strict_types=1);

namespace Modules\Wallet\Enums;

enum TransactionType: string
{
    case TopUp = 'TOP_UP';
    case P2pTransfer = 'P2P_TRANSFER';
    case Withdrawal = 'WITHDRAWAL';
    case Refund = 'REFUND';
    
}
