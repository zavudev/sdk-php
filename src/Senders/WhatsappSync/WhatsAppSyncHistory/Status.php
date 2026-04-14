<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync\WhatsAppSyncHistory;

/**
 * Status of WhatsApp message history sync.
 */
enum Status: string
{
    case NOT_REQUESTED = 'not_requested';

    case PENDING = 'pending';

    case SYNCING = 'syncing';

    case COMPLETED = 'completed';

    case REJECTED = 'rejected';
}
