<?php

declare(strict_types=1);

namespace Zavudev\Invitations\InvitationCreateParams;

/**
 * Which Meta channel the client connects, and how.
 * - `whatsapp_waba` (default): Meta's embedded signup links an official WhatsApp Business Account. Accepts `phoneNumberId` and `allowedPhoneCountries`.
 * - `messenger`: the client authorizes with Facebook and picks a Facebook Page they administer. The Page's Messenger inbox — including Marketplace chats — is routed to Zavu. They must be an admin of at least one Page. A Page can only be connected to one Zavu project at a time: if the client picks a Page that another project already connected, the newer connection wins and the older one is disconnected.
 *
 * One invitation connects one channel. To onboard a client on several channels, create one invitation per channel; each completes into its own sender.
 */
enum ConnectionType: string
{
    case WHATSAPP_WABA = 'whatsapp_waba';

    case MESSENGER = 'messenger';
}
