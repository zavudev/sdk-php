<?php

declare(strict_types=1);

namespace Zavudev\Plan\PlanGetResponse;

/**
 * Current subscription tier.
 */
enum Tier: string
{
    case FREE = 'free';

    case PRO = 'pro';

    case SCALE = 'scale';

    case ENTERPRISE = 'enterprise';
}
