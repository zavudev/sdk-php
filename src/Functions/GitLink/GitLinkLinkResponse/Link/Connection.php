<?php

declare(strict_types=1);

namespace Zavudev\Functions\GitLink\GitLinkLinkResponse\Link;

/**
 * How this link authenticates, decided by the server rather than by the caller.
 * - `app`: the Zavu GitHub App is installed on the account. Pushes arrive on the app's webhook and private repositories work. Nothing to configure in the repository.
 * - `manual`: no installation. The link carries its own secret and you add the webhook to the repository yourself.
 */
enum Connection: string
{
    case APP = 'app';

    case MANUAL = 'manual';
}
