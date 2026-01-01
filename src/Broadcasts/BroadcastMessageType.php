<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

/**
 * Type of message for broadcast.
 */
enum BroadcastMessageType: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case VIDEO = 'video';

    case AUDIO = 'audio';

    case DOCUMENT = 'document';

    case TEMPLATE = 'template';
}
