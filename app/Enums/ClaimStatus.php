<?php

namespace App\Enums;

enum ClaimStatus: int
{
    case ACTIVE = 1;
    case NEW = 2;
    case IN_PROGRESS = 3;
    case COMPLETED = 4;
}
