<?php

declare(strict_types=1);

namespace Zavudev\Services\SubAccounts;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\SubAccounts\APIKeysContract;
use Zavudev\SubAccounts\APIKeys\APIKeyCreateParams\Environment;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class APIKeysService implements APIKeysContract
{
    /**
     * @api
     */
    public APIKeysRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new APIKeysRawService($client);
    }

    /**
     * @api
     *
     * Create sub-account API key
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
    ): APIKeyNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'environment' => $environment,
                'permissions' => $permissions,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List sub-account API keys
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): APIKeyListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Revoke sub-account API key
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
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        $params = Util::removeNulls(['id' => $id]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->revoke($keyID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
