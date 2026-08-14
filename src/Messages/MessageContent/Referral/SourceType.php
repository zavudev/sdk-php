<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent\Referral;

/**
 * Where the click came from.
 */
enum SourceType: string
{
    case AD = 'ad';

    case POST = 'post';
}
