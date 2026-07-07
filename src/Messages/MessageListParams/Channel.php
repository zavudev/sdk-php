<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageListParams;

/**
 * Filter by delivery channel.
 */
enum Channel: string
{
    case SMS = 'sms';

    case SMS_ONEWAY = 'sms_oneway';

    case WHATSAPP = 'whatsapp';

    case EMAIL = 'email';

    case TELEGRAM = 'telegram';

    case INSTAGRAM = 'instagram';

    case MESSENGER = 'messenger';

    case VOICE = 'voice';
}
