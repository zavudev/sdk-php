<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync\WhatsAppSyncStatus;

/**
 * WhatsApp account status.
 */
enum Status: string
{
    case PENDING_VERIFICATION = 'pending_verification';

    case PENDING_REGISTRATION = 'pending_registration';

    case ACTIVE = 'active';

    case DISCONNECTED = 'disconnected';

    case ERROR = 'error';
}
