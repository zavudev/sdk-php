<?php

declare(strict_types=1);

namespace Zavudev\Invitations\Invitation;

/**
 * How the client connects WhatsApp: `whatsapp_waba` (official Cloud API via embedded signup).
 */
enum ConnectionType: string
{
    case WHATSAPP_WABA = 'whatsapp_waba';
}
