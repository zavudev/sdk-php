<?php

namespace Zavudev\Core\Exceptions;

class PermissionDeniedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'Zavudev Permission Denied Exception';
}
