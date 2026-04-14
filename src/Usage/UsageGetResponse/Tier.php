<?php

declare(strict_types=1);

namespace Zavudev\Usage\UsageGetResponse;

enum Tier: string
{
    case FREE = 'free';

    case PRO = 'pro';

    case SCALE = 'scale';

    case ENTERPRISE = 'enterprise';
}
