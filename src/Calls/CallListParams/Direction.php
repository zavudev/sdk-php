<?php

declare(strict_types=1);

namespace Zavudev\Calls\CallListParams;

/**
 * Whether the call was placed by Zavu (outbound) or received from a caller (inbound).
 */
enum Direction: string
{
    case INBOUND = 'inbound';

    case OUTBOUND = 'outbound';
}
