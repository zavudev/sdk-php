<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Plan\PlanGetResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\PlanContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class PlanService implements PlanContract
{
    /**
     * @api
     */
    public PlanRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PlanRawService($client);
    }

    /**
     * @api
     *
     * Get the current subscription plan for the API key's team, including tier, billing interval, and period dates.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): PlanGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }
}
