<?php

namespace App;

enum ActionEnum:string
{
    case Create =  'create';
    case Update =  'update';
    case Delete =  'delete';
}
