<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys\APIKeyNewResponse\APIKey;

enum Environment: string
{
    case LIVE = 'live';

    case TEST = 'test';
}
