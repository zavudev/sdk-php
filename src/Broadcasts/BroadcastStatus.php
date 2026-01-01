<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

/**
 * Current status of the broadcast.
 */
enum BroadcastStatus: string
{
    case DRAFT = 'draft';

    case SCHEDULED = 'scheduled';

    case SENDING = 'sending';

    case PAUSED = 'paused';

    case COMPLETED = 'completed';

    case CANCELLED = 'cancelled';

    case FAILED = 'failed';
}
