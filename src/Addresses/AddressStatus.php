<?php

declare(strict_types=1);

namespace Zavudev\Addresses;

enum AddressStatus: string
{
    case PENDING = 'pending';

    case VERIFIED = 'verified';

    case REJECTED = 'rejected';
}
