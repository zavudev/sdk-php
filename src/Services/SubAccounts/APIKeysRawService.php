<?php

declare(strict_types=1);

namespace Zavudev\Services\SubAccounts;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\SubAccounts\APIKeysRawContract;
use Zavudev\SubAccounts\APIKeys\APIKeyCreateParams;
use Zavudev\SubAccounts\APIKeys\APIKeyCreateParams\Environment;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyRevokeParams;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class APIKeysRawService implements APIKeysRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create sub-account API key. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param array{
     *   name: string,
     *   environment?: Environment|value-of<Environment>,
     *   permissions?: list<string>,
     * }|APIKeyCreateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = APIKeyCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/sub-accounts/%1$s/api-keys', $id],
            body: (object) $parsed,
            options: $options,
            convert: APIKeyNewResponse::class,
        );
    }

    /**
     * @api
     *
     * List sub-account API keys. Requires a parent project API key; sub-account API keys receive HTTP 403.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sub-accounts/%1$s/api-keys', $id],
            options: $requestOptions,
            convert: APIKeyListResponse::class,
        );
    }

    /**
     * @api
     *
     * Revoke sub-account API key. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $keyID API key ID
     * @param array{id: string}|APIKeyRevokeParams $params
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
    ): BaseResponse {
        [$parsed, $options] = APIKeyRevokeParams::parseRequest(
            $params,
            $requestOptions,
        );
        $id = $parsed['id'];
        unset($parsed['id']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/sub-accounts/%1$s/api-keys/%2$s', $id, $keyID],
            options: $options,
            convert: null,
        );
    }
}
