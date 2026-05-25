<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionGetResponse\Function_;

/**
 * Runtime the function is deployed on.
 */
enum Runtime: string
{
    case NODEJS24 = 'nodejs24';
}
