<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Channels\ChannelAddParams;

/**
 * Channel type.
 */
enum Channel: string
{
    case SMS = 'sms';

    case WHATSAPP = 'whatsapp';

    case EMAIL = 'email';

    case TELEGRAM = 'telegram';

    case VOICE = 'voice';
}
