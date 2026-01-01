<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

/**
 * Type of requirement field.
 */
enum RequirementFieldType: string
{
    case TEXTUAL = 'textual';

    case ADDRESS = 'address';

    case DOCUMENT = 'document';

    case ACTION = 'action';
}
