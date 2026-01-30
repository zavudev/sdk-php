<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Contact;

/**
 * Preferred channel for this contact.
 */
enum DefaultChannel: string
{
    case SMS = 'sms';

    case WHATSAPP = 'whatsapp';

    case TELEGRAM = 'telegram';

    case EMAIL = 'email';

    case INSTAGRAM = 'instagram';

    case VOICE = 'voice';
}
