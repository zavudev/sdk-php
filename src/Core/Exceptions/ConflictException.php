<?php

namespace Zavudev\Core\Exceptions;

class ConflictException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Conflict Exception';
}
