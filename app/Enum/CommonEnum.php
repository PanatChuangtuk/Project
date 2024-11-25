<?php

namespace App\Enum;

enum CommonEnum: string
{
    case CONDITION = 'term_and_condition';
    case POLICY = 'privacy_policy';
    case SERVICE = 'service';
}
