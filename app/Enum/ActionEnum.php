<?php

namespace App\Enum;

enum ActionEnum: string
{
    case Create =  'create';
    case Update =  'update';
    case Delete =  'delete';
}
