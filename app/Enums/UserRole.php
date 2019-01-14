<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const Administrator = "admin";
    const HumanResource = "hr";
    const Finance = "finance";
}
