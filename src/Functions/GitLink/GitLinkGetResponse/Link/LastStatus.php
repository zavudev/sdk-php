<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink\GitLinkGetResponse\Link;

enum LastStatus: string
{
    case DEPLOYING = 'deploying';

    case DEPLOYED = 'deployed';

    case FAILED = 'failed';
}
