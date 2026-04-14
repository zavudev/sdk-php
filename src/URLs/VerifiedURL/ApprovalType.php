<?php

declare(strict_types=1);

namespace Zavudev\URLs\VerifiedURL;

/**
 * How the URL was approved or rejected.
 */
enum ApprovalType: string
{
    case MANUAL = 'manual';

    case AUTO_WEB_RISK = 'auto_web_risk';
}
