<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent;

/**
 * Optional header type for cta_url messages.
 */
enum CtaHeaderType: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case VIDEO = 'video';

    case DOCUMENT = 'document';
}
