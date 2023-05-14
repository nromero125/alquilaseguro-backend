<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum IdentificationTypes: int
{
    use Options;

    case DOMINICAN_ID = 1;
    case PASSPORT_ID = 2;
}
