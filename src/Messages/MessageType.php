<?php

declare(strict_types=1);

namespace Zavudev\Messages;

/**
 * Type of message. Non-text types are supported by WhatsApp and Telegram (varies by type).
 *
 * `location_request` asks the recipient to share their location and is WhatsApp-only. It takes no `content` object — the prompt goes in `text` (max 1024 characters) and the button label is fixed by WhatsApp. The recipient's answer arrives as an inbound `location` message whose `content.replyToMessageId` is the ID of the request.
 */
enum MessageType: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case VIDEO = 'video';

    case AUDIO = 'audio';

    case DOCUMENT = 'document';

    case STICKER = 'sticker';

    case LOCATION = 'location';

    case CONTACT = 'contact';

    case BUTTONS = 'buttons';

    case LIST = 'list';

    case CTA_URL = 'cta_url';

    case LOCATION_REQUEST = 'location_request';

    case REACTION = 'reaction';

    case TEMPLATE = 'template';
}
