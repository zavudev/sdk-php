<?php

declare(strict_types=1);

namespace Zavudev\Core\Conversion\Contracts;

use Zavudev\Core\Conversion\CoerceState;
use Zavudev\Core\Conversion\DumpState;

/**
 * @internal
 */
interface Converter
{
    /**
     * @internal
     */
    public function coerce(mixed $value, CoerceState $state): mixed;

    /**
     * @internal
     */
    public function dump(mixed $value, DumpState $state): mixed;
}
