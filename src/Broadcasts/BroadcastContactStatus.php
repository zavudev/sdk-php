<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

/**
 * Status of a contact within a broadcast.
 */
enum BroadcastContactStatus: string
{
    case PENDING = 'pending';

    case QUEUED = 'queued';

    case SENDING = 'sending';

    case DELIVERED = 'delivered';

    case FAILED = 'failed';

    case SKIPPED = 'skipped';
}
