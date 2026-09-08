<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

/**
 * Type of phone number. `mobile` is stocked in countries where no geographic (`local`) or non-geographic (`national`) inventory exists, and in several markets it is the only type that can receive SMS.
 */
enum PhoneNumberType: string
{
    case LOCAL = 'local';

    case NATIONAL = 'national';

    case TOLL_FREE = 'tollFree';

    case MOBILE = 'mobile';
}
