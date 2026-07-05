<?php

declare(strict_types=1);

namespace Zavudev\Messages;

/**
 * Delivery channel. Use 'auto' for intelligent routing. `whatsapp_alt` is the QR-linked WhatsApp channel and is only accepted for teams with the WhatsApp Alternative feature enabled; the sender must have a connected whatsapp_alt session.
 */
enum Channel: string
{
    case AUTO = 'auto';

    case SMS = 'sms';

    case SMS_ONEWAY = 'sms_oneway';

    case WHATSAPP = 'whatsapp';

    case WHATSAPP_ALT = 'whatsapp_alt';

    case TELEGRAM = 'telegram';

    case EMAIL = 'email';

    case INSTAGRAM = 'instagram';

    case MESSENGER = 'messenger';

    case VOICE = 'voice';
}
