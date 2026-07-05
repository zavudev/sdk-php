<?php

declare(strict_types=1);

namespace Zavudev\Invitations\InvitationCreateParams;

/**
 * How the client connects WhatsApp. `whatsapp_waba` (default) runs Meta's embedded signup to link an official WhatsApp Business Account. `whatsapp_alt` links the number by scanning a QR code — available only to teams with the WhatsApp Alternative feature enabled.
 */
enum ConnectionType: string
{
    case WHATSAPP_WABA = 'whatsapp_waba';

    case WHATSAPP_ALT = 'whatsapp_alt';
}
