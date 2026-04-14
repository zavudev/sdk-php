<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\SubAccounts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\SubAccounts\APIKeys\APIKeyCreateParams\Environment;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface APIKeysContract
{
    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param Environment|value-of<Environment> $environment
     * @param list<string> $permissions
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $id,
        string $name,
        Environment|string $environment = 'live',
        ?array $permissions = null,
        RequestOptions|array|null $requestOptions = null,
    ): APIKeyNewResponse;

    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIKeyListResponse;

    /**
     * @api
     *
     * @param string $keyID API key ID
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function revoke(
        string $keyID,
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
