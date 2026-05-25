<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Me\MeGetResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\MeContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class MeService implements MeContract
{
    /**
     * @api
     */
    public MeRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MeRawService($client);
    }

    /**
     * @api
     *
     * Returns the project, team, and API key metadata bound to the current Bearer token. Used by CLIs and SDKs to confirm which project they will operate on.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): MeGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }
}
