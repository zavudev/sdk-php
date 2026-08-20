<?php

declare(strict_types=1);

namespace Zavudev\Messages\Message;

/**
 * Who sent the message. Needed to render a thread: `status` cannot tell the two apart, because an inbound message is also stored as `delivered`.
 */
enum Direction: string
{
    case INBOUND = 'inbound';

    case OUTBOUND = 'outbound';
}
