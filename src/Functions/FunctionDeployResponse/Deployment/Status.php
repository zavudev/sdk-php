<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionDeployResponse\Deployment;

/**
 * Stage of a function deployment.
 */
enum Status: string
{
    case PENDING = 'pending';

    case BUNDLING = 'bundling';

    case UPLOADING = 'uploading';

    case PUBLISHING = 'publishing';

    case ACTIVE = 'active';

    case FAILED = 'failed';

    case SUPERSEDED = 'superseded';
}
