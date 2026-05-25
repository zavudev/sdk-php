<?php

declare(strict_types=1);

namespace Zavudev\Services\Functions;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Functions\Secrets\SecretListResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Functions\SecretsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SecretsService implements SecretsContract
{
    /**
     * @api
     */
    public SecretsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SecretsRawService($client);
    }

    /**
     * @api
     *
     * Lists every secret key set on the function. Plaintext is NEVER returned — only the last 4 characters of each value, for visual confirmation.
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): SecretListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($functionID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Create or update a secret on a function. Marks the function out-of-sync; the next `POST /deploy` re-publishes the Lambda with the new env. Keys must match `[A-Z_][A-Z0-9_]*` (uppercase env-var style) and cannot start with reserved prefixes (AWS_, LAMBDA_, etc).
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
    ): mixed {
        $params = Util::removeNulls(
            ['functionID' => $functionID, 'value' => $value]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->set($key, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a secret from a function. Doesn't take effect on the running Lambda until the next deploy.
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
    ): mixed {
        $params = Util::removeNulls(['functionID' => $functionID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->unset($key, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
