<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\SubAccount;

enum Status: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';
}
