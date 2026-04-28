<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\PhoneNumbers\TenDlcPhoneNumberAssignment;

/**
 * Assignment status.
 */
enum Status: string
{
    case PENDING = 'pending';

    case ACTIVE = 'active';

    case FAILED = 'failed';
}
