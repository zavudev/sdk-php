<?php

declare(strict_types=1);

namespace Zavudev\Invitations\InvitationCreateParams;

/**
 * How the client connects WhatsApp. `whatsapp_waba` (default) runs Meta's embedded signup to link an official WhatsApp Business Account.
 */
enum ConnectionType: string
{
    case WHATSAPP_WABA = 'whatsapp_waba';
}
