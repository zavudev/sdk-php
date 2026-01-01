<?php

namespace Zavudev\Core\Exceptions;

class NotFoundException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Not Found Exception';
}
