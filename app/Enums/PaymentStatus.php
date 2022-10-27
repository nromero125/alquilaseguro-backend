<?php

namespace App\Enums;

enum PaymentTypes: int
{
    case PENDING = 1;
    case CONFIRMED = 2;
}
