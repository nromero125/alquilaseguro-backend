<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum ClaimStatus: int
{
    use Options;

    case Declined = 1;
    case New = 2;
    case In_progress = 3;
    case Completed = 4;
}
