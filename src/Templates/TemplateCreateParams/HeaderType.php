<?php

declare(strict_types=1);

namespace Zavudev\Templates\TemplateCreateParams;

/**
 * Type of header for the template.
 */
enum HeaderType: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case VIDEO = 'video';

    case DOCUMENT = 'document';
}
