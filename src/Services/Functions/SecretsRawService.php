<?php

declare(strict_types=1);

namespace Zavudev\Services\Functions;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\Secrets\SecretListResponse;
use Zavudev\Functions\Secrets\SecretSetParams;
use Zavudev\Functions\Secrets\SecretUnsetParams;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Functions\SecretsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SecretsRawService implements SecretsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Lists every secret key set on the function. Plaintext is NEVER returned — only the last 4 characters of each value, for visual confirmation.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/functions/%1$s/secrets', $functionID],
            options: $requestOptions,
            convert: SecretListResponse::class,
        );
    }

    /**
     * @api
     *
     * Create or update a secret on a function. Marks the function out-of-sync; the next `POST /deploy` re-publishes the Lambda with the new env. Keys must match `[A-Z_][A-Z0-9_]*` (uppercase env-var style) and cannot start with reserved prefixes (AWS_, LAMBDA_, etc).
     *
     * @param string $key Path param
     * @param array{functionID: string, value: string}|SecretSetParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SecretSetParams::parseRequest(
            $params,
            $requestOptions,
        );
        $functionID = $parsed['functionID'];
        unset($parsed['functionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['v1/functions/%1$s/secrets/%2$s', $functionID, $key],
            body: (object) array_diff_key($parsed, array_flip(['functionID'])),
            options: $options,
            convert: 'mixed',
        );
    }

    /**
     * @api
     *
     * Remove a secret from a function. Doesn't take effect on the running Lambda until the next deploy.
     *
     * @param array{functionID: string}|SecretUnsetParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SecretUnsetParams::parseRequest(
            $params,
            $requestOptions,
        );
        $functionID = $parsed['functionID'];
        unset($parsed['functionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/functions/%1$s/secrets/%2$s', $functionID, $key],
            options: $options,
            convert: null,
        );
    }
}
