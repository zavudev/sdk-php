<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Introspect\IntrospectValidateEmailParams;
use Zavudev\Introspect\IntrospectValidateEmailResponse;
use Zavudev\Introspect\IntrospectValidatePhoneParams;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface IntrospectRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|IntrospectValidateEmailParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntrospectValidateEmailResponse>
     *
     * @throws APIException
     */
    public function validateEmail(
        array|IntrospectValidateEmailParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|IntrospectValidatePhoneParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntrospectValidatePhoneResponse>
     *
     * @throws APIException
     */
    public function validatePhone(
        array|IntrospectValidatePhoneParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
