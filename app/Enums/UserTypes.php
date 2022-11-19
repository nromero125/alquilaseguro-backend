<?php

namespace App\Enums;

enum UserTypes: int
{
    case ADMIN = 1;
    case INSURER = 2;
    case OWNER = 3;
    case TENANT = 4;
    case BROKER = 5;
    case BROKER_ADMIN = 6;
    case INSURER_ADMIN = 7;
    case USER = 8;
}
