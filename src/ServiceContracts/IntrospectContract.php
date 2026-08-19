<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Introspect\IntrospectValidateEmailResponse;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface IntrospectContract
{
    /**
     * @api
     *
     * @param string $email single email address to validate
     * @param list<string> $emails batch of email addresses to validate (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validateEmail(
        ?string $email = null,
        ?array $emails = null,
        RequestOptions|array|null $requestOptions = null,
    ): IntrospectValidateEmailResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validatePhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): IntrospectValidatePhoneResponse;
}
