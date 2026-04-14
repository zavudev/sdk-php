<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Balance\BalanceGetResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface BalanceContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BalanceGetResponse;
}
