<?php

declare(strict_types=1);

namespace Zavudev\Core\Conversion;

use Zavudev\Core\Conversion\Concerns\ArrayOf;
use Zavudev\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class MapOf implements Converter
{
    use ArrayOf;
}
