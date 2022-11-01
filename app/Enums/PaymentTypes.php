<?php

namespace App\Enums;

enum PaymentTypes: int
{
    case PROPERTY_PAYMENT = 1;
    case BROKER_PAYMENT = 2;
    case INSURANCE_PAYMENT = 3;
}
