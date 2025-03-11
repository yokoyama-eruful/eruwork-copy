<?php

declare(strict_types=1);

namespace Modules\Chat\Enums;

enum ChatGroupType: string
{
    case ALL = 'all';
    case DM = 'dm';
    case GROUP = 'group';
}
