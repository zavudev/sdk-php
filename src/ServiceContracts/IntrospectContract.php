<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;

interface IntrospectContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function validatePhone(
        string $phoneNumber,
        ?RequestOptions $requestOptions = null
    ): IntrospectValidatePhoneResponse;
}
