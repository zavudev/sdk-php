<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\SubAccounts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\SubAccounts\APIKeys\APIKeyCreateParams;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyRevokeParams;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface APIKeysRawContract
{
    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param array<string,mixed>|APIKeyCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|APIKeyCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $keyID API key ID
     * @param array<string,mixed>|APIKeyRevokeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function revoke(
        string $keyID,
        array|APIKeyRevokeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
