<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum PaymentTypes: int
{
    use Options;

    case PROPERTY_PAYMENT = 1;
    case BROKER_PAYMENT = 2;
    case INSURANCE_PAYMENT = 3;
    case OWNER_PAYMENT = 4;
}
