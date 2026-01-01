<?php

namespace Zavudev\Core\Exceptions;

class BadRequestException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Bad Request Exception';
}
