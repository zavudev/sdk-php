<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync\WhatsAppSyncContacts;

/**
 * Status of WhatsApp contacts sync.
 */
enum Status: string
{
    case NOT_REQUESTED = 'not_requested';

    case PENDING = 'pending';

    case SYNCING = 'syncing';

    case COMPLETED = 'completed';
}
