<?php

declare(strict_types=1);

namespace Zavudev\Templates;

/**
 * WhatsApp template category.
 */
enum WhatsappCategory: string
{
    case UTILITY = 'UTILITY';

    case MARKETING = 'MARKETING';

    case AUTHENTICATION = 'AUTHENTICATION';
}
