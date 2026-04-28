<?php

declare(strict_types=1);

namespace Zavudev\Plan\PlanGetResponse;

enum BillingInterval: string
{
    case MONTHLY = 'monthly';

    case ANNUAL = 'annual';
}
