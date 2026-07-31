<?php

declare(strict_types=1);

namespace Zavudev\Invitations\Invitation;

/**
 * Which Meta channel the client connects: `whatsapp_waba` (official WhatsApp Cloud API via embedded signup) or `messenger` (a Facebook Page's Messenger inbox, including Marketplace chats).
 */
enum ConnectionType: string
{
    case WHATSAPP_WABA = 'whatsapp_waba';

    case MESSENGER = 'messenger';
}
