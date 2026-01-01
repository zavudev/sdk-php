<?php

declare(strict_types=1);

namespace Zavudev\Introspect;

/**
 * Type of phone line.
 */
enum LineType: string
{
    case MOBILE = 'mobile';

    case LANDLINE = 'landline';

    case VOIP = 'voip';

    case TOLL_FREE = 'toll_free';

    case UNKNOWN = 'unknown';
}
