<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Balance\BalanceGetResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\BalanceContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class BalanceService implements BalanceContract
{
    /**
     * @api
     */
    public BalanceRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BalanceRawService($client);
    }

    /**
     * @api
     *
     * Get balance for the API key's team. If the API key belongs to a sub-account, also includes the sub-account's total spending and credit limit.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BalanceGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }
}
