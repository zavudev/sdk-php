<?php

declare(strict_types=1);

namespace Zavudev\Functions\FunctionCreateParams;

enum MemoryMB: int
{
    case _128 = 128;

    case _256 = 256;

    case _512 = 512;

    case _1024 = 1024;
}
