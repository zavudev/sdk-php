<?php

namespace Zavudev\Core\Exceptions;

class UnprocessableEntityException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Unprocessable Entity Exception';
}
