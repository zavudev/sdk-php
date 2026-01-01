<?php

namespace Zavudev\Core\Exceptions;

class AuthenticationException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Authentication Exception';
}
