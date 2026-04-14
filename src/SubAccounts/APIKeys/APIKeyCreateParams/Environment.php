<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys\APIKeyCreateParams;

enum Environment: string
{
    case LIVE = 'live';

    case TEST = 'test';
}
