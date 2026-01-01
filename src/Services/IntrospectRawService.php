<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Introspect\IntrospectValidatePhoneParams;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\IntrospectRawContract;

final class IntrospectRawService implements IntrospectRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Validate a phone number and check if a WhatsApp conversation window is open.
     *
     * @param array{phoneNumber: string}|IntrospectValidatePhoneParams $params
     *
     * @return BaseResponse<IntrospectValidatePhoneResponse>
     *
     * @throws APIException
     */
    public function validatePhone(
        array|IntrospectValidatePhoneParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IntrospectValidatePhoneParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/introspect/phone',
            body: (object) $parsed,
            options: $options,
            convert: IntrospectValidatePhoneResponse::class,
        );
    }
}
