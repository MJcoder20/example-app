<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;



final class TokenAbility extends Enum
{
    const ISSUE_ACCESS_TOKEN = 'issue-access-token';
    const ACCESS_API = 'access-api';
}
