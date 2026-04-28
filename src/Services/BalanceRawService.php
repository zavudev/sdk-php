<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Balance\BalanceGetResponse;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\BalanceRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class BalanceRawService implements BalanceRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get balance for the API key's team. If the API key belongs to a sub-account, also includes the sub-account's total spending and credit limit.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BalanceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/balance',
            options: $requestOptions,
            convert: BalanceGetResponse::class,
        );
    }
}
