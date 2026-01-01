<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

enum PhoneNumberStatus: string
{
    case ACTIVE = 'active';

    case SUSPENDED = 'suspended';

    case PENDING = 'pending';
}
