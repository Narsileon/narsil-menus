<?php

namespace Narsil\Menus\Enums;

enum VisibilityEnum: string
{
    case AUTH = 'auth';
    case GUEST = 'guest';
    case USER = 'user';
}
