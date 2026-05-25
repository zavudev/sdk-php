<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionCreateParams;

/**
 * Runtime the function is deployed on.
 */
enum Runtime: string
{
    case NODEJS24 = 'nodejs24';
}
