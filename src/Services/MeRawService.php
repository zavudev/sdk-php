<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Me\MeGetResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\MeRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class MeRawService implements MeRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns the project, team, and API key metadata bound to the current Bearer token. Used by CLIs and SDKs to confirm which project they will operate on.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MeGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/me',
            options: $requestOptions,
            convert: MeGetResponse::class,
        );
    }
}
