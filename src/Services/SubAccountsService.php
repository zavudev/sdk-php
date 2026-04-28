<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\SubAccountsContract;
use Zavudev\Services\SubAccounts\APIKeysService;
use Zavudev\SubAccounts\SubAccount;
use Zavudev\SubAccounts\SubAccountDeactivateResponse;
use Zavudev\SubAccounts\SubAccountGetBalanceResponse;
use Zavudev\SubAccounts\SubAccountGetResponse;
use Zavudev\SubAccounts\SubAccountNewResponse;
use Zavudev\SubAccounts\SubAccountUpdateParams\Status;
use Zavudev\SubAccounts\SubAccountUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SubAccountsService implements SubAccountsContract
{
    /**
     * @api
     */
    public SubAccountsRawService $raw;

    /**
     * @api
     */
    public APIKeysService $apiKeys;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SubAccountsRawService($client);
        $this->apiKeys = new APIKeysService($client);
    }

    /**
     * @api
     *
     * Create a new sub-account (project) with its own API key. All charges are billed to the parent team's balance. Use creditLimit to set a spending cap. The sub-account's API key is returned only in the creation response. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $name name of the sub-account
     * @param int $creditLimit Spending cap in cents. When reached, messages from this sub-account will be blocked. Omit or set to 0 for no limit.
     * @param string $externalID external reference ID for your own tracking
     * @param array<string,mixed> $metadata
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?int $creditLimit = null,
        ?string $externalID = null,
        ?array $metadata = null,
        RequestOptions|array|null $requestOptions = null,
    ): SubAccountNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'creditLimit' => $creditLimit,
                'externalID' => $externalID,
                'metadata' => $metadata,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get sub-account. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): SubAccountGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update sub-account. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param array<string,mixed> $metadata
     * @param Status|value-of<Status> $status
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?int $creditLimit = null,
        ?string $externalID = null,
        ?array $metadata = null,
        ?string $name = null,
        Status|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): SubAccountUpdateResponse {
        $params = Util::removeNulls(
            [
                'creditLimit' => $creditLimit,
                'externalID' => $externalID,
                'metadata' => $metadata,
                'name' => $name,
                'status' => $status,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List sub-accounts for this team. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<SubAccount>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deactivate a sub-account. Remaining balance is returned to the parent team and all API keys are revoked. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): SubAccountDeactivateResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deactivate($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get spending information for a sub-account. Returns the parent team's balance, the sub-account's total spending, and its credit limit (spending cap). Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getBalance(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): SubAccountGetBalanceResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getBalance($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
