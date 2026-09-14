<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

/**
 * Billing state of an owned number, separate from `regulatoryStatus`. `pending` is legacy and is not written to numbers today. The SDKs carry `active`, `suspended` and `pending` only; `releasing` and `released` are returned by the REST API until their next release.
 */
enum PhoneNumberStatus: string
{
    case ACTIVE = 'active';

    case SUSPENDED = 'suspended';

    case PENDING = 'pending';

    case RELEASING = 'releasing';

    case RELEASED = 'released';
}
