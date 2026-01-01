<?php

declare(strict_types=1);

namespace Zavudev\Messages;

/**
 * Type of message. Non-text types are WhatsApp only.
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

    case REACTION = 'reaction';

    case TEMPLATE = 'template';
}
