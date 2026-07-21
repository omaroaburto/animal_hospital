<?php

namespace App\Domains\Inventary\Enums;

enum MovementType: string
{
    case PURCHASE = 'purchase';
    case SALE = 'sale';
    case TREATMENT = 'treatment';
    case ADJUSTMENT = 'adjustment';
    case EXPIRED = 'expired';
    case DAMAGED = 'damaged';
    case RETURN = 'return';
}
