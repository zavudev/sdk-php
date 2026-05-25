<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionNewResponse\Function_;

/**
 * Lifecycle status of a Zavu Function.
 */
enum Status: string
{
    case DRAFT = 'draft';

    case BUNDLING = 'bundling';

    case DEPLOYING = 'deploying';

    case ACTIVE = 'active';

    case FAILED = 'failed';

    case DISABLED = 'disabled';
}
