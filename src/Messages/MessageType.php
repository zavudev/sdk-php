<?php

declare(strict_types=1);

namespace Zavudev\Messages;

/**
 * Type of message. Non-text types are supported by WhatsApp and Telegram (varies by type).
 *
 * `location_request` asks the recipient to share their location and is WhatsApp-only. It takes no `content` object — the prompt goes in `text` (max 1024 characters) and the button label is fixed by WhatsApp. The recipient's answer arrives as an inbound `location` message whose `content.replyToMessageId` is the ID of the request.
 *
 * `request_contact_info` asks the recipient to share their phone number and is WhatsApp-only. Like `location_request` it takes no `content` object — the prompt goes in `text` (max 1024 characters) and WhatsApp renders a fixed **Share Contact Info** button. The answer arrives as an inbound `contact` message. Use it to recover the phone number of a contact who adopted a WhatsApp username and is only known by their business-scoped user ID (BSUID); when they share it, Zavu automatically links the phone number to that contact.
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

    case REQUEST_CONTACT_INFO = 'request_contact_info';

    case LOCATION_REQUEST = 'location_request';

    case REACTION = 'reaction';

    case TEMPLATE = 'template';
}
