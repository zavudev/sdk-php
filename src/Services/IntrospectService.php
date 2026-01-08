<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\IntrospectContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class IntrospectService implements IntrospectContract
{
    /**
     * @api
     */
    public IntrospectRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new IntrospectRawService($client);
    }

    /**
     * @api
     *
     * Validate a phone number and check if a WhatsApp conversation window is open.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validatePhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): IntrospectValidatePhoneResponse {
        $params = Util::removeNulls(['phoneNumber' => $phoneNumber]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->validatePhone(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
