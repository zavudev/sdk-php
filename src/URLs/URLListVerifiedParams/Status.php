<?php

declare(strict_types=1);

namespace Zavudev\URLs\URLListVerifiedParams;

/**
 * Filter by verification status.
 */
enum Status: string
{
    case PENDING = 'pending';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

    case MALICIOUS = 'malicious';
}
