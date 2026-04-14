<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\SubAccountUpdateParams;

enum Status: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
