<?php

declare(strict_types=1);

namespace Zavudev\Contacts\ContactUpdateParams;

/**
 * Preferred channel for this contact. Set to null to clear.
 */
enum DefaultChannel: string
{
    case SMS = 'sms';

    case WHATSAPP = 'whatsapp';

    case TELEGRAM = 'telegram';

    case EMAIL = 'email';

    case INSTAGRAM = 'instagram';
}
