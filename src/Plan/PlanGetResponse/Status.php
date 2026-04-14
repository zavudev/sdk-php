<?php

declare(strict_types=1);

namespace Zavudev\Plan\PlanGetResponse;

enum Status: string
{
    case ACTIVE = 'active';

    case PAST_DUE = 'past_due';

    case CANCELED = 'canceled';

    case TRIALING = 'trialing';
}
