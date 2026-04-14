<?php

declare(strict_types=1);

namespace Zavudev\URLs\VerifiedURL;

/**
 * Status of a verified URL.
 */
enum Status: string
{
    case PENDING = 'pending';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

    case MALICIOUS = 'malicious';
}
