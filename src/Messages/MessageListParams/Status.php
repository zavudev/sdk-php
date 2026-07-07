<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageListParams;

/**
 * Filter by status. Not all stored statuses are filterable.
 */
enum Status: string
{
    case QUEUED = 'queued';

    case SENDING = 'sending';

    case SENT = 'sent';

    case DELIVERED = 'delivered';

    case FAILED = 'failed';

    case RECEIVED = 'received';
}
