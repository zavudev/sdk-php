<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

enum PhoneNumberType: string
{
    case LOCAL = 'local';

    case MOBILE = 'mobile';

    case TOLL_FREE = 'tollFree';
}
