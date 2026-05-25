<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Functions;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\Secrets\SecretListResponse;
use Zavudev\Functions\Secrets\SecretSetParams;
use Zavudev\Functions\Secrets\SecretUnsetParams;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SecretsRawContract
{
    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SecretListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $key Path param
     * @param array<string,mixed>|SecretSetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function set(
        string $key,
        array|SecretSetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SecretUnsetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function unset(
        string $key,
        array|SecretUnsetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
