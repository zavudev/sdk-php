<?php

namespace Zavudev\Core\Exceptions;

class RateLimitException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Rate Limit Exception';
}
