<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Functions;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\Secrets\SecretListResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SecretsContract
{
    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): SecretListResponse;

    /**
     * @api
     *
     * @param string $key Path param
     * @param string $functionID path param: Zavu Function ID
     * @param string $value Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function set(
        string $key,
        string $functionID,
        string $value,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unset(
        string $key,
        string $functionID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
