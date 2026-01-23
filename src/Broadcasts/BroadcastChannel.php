<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

/**
 * Broadcast delivery channel. Use 'smart' for per-contact intelligent routing.
 */
enum BroadcastChannel: string
{
    case SMART = 'smart';

    case SMS = 'sms';

    case WHATSAPP = 'whatsapp';

    case TELEGRAM = 'telegram';

    case EMAIL = 'email';
}
