<?php

namespace Zavudev\Core\Exceptions;

class InternalServerException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Internal Server Exception';
}
