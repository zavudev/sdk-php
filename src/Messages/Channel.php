<?php

declare(strict_types=1);

namespace Zavudev\Messages;

/**
 * Delivery channel. Use 'auto' for intelligent routing.
 */
enum Channel: string
{
    case AUTO = 'auto';

    case SMS = 'sms';

    case WHATSAPP = 'whatsapp';

    case TELEGRAM = 'telegram';

    case EMAIL = 'email';
}
