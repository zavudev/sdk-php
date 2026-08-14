<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent\Referral;

/**
 * Type of media on the ad, when it had any.
 */
enum MediaType: string
{
    case IMAGE = 'image';

    case VIDEO = 'video';
}
