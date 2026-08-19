<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink\GitLinkLinkResponse\Link;

enum LastStatus: string
{
    case DEPLOYING = 'deploying';

    case DEPLOYED = 'deployed';

    case FAILED = 'failed';
}
