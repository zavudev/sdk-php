<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\SubAccountsRawContract;
use Zavudev\SubAccounts\SubAccount;
use Zavudev\SubAccounts\SubAccountCreateParams;
use Zavudev\SubAccounts\SubAccountDeactivateResponse;
use Zavudev\SubAccounts\SubAccountGetBalanceResponse;
use Zavudev\SubAccounts\SubAccountGetResponse;
use Zavudev\SubAccounts\SubAccountListParams;
use Zavudev\SubAccounts\SubAccountNewResponse;
use Zavudev\SubAccounts\SubAccountUpdateParams;
use Zavudev\SubAccounts\SubAccountUpdateParams\Status;
use Zavudev\SubAccounts\SubAccountUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SubAccountsRawService implements SubAccountsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new sub-account (project) with its own API key. All charges are billed to the parent team's balance. Use creditLimit to set a spending cap. The sub-account's API key is returned only in the creation response. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param array{
     *   name: string,
     *   creditLimit?: int,
     *   externalID?: string,
     *   metadata?: array<string,mixed>,
     * }|SubAccountCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubAccountNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SubAccountCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SubAccountCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/sub-accounts',
            body: (object) $parsed,
            options: $options,
            convert: SubAccountNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get sub-account. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubAccountGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sub-accounts/%1$s', $id],
            options: $requestOptions,
            convert: SubAccountGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update sub-account. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param array{
     *   creditLimit?: int|null,
     *   externalID?: string,
     *   metadata?: array<string,mixed>,
     *   name?: string,
     *   status?: Status|value-of<Status>,
     * }|SubAccountUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubAccountUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|SubAccountUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SubAccountUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/sub-accounts/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: SubAccountUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List sub-accounts for this team. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param array{cursor?: string, limit?: int}|SubAccountListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<SubAccount>>
     *
     * @throws APIException
     */
    public function list(
        array|SubAccountListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SubAccountListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/sub-accounts',
            query: $parsed,
            options: $options,
            convert: SubAccount::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Deactivate a sub-account. Remaining balance is returned to the parent team and all API keys are revoked. Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubAccountDeactivateResponse>
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/sub-accounts/%1$s', $id],
            options: $requestOptions,
            convert: SubAccountDeactivateResponse::class,
        );
    }

    /**
     * @api
     *
     * Get spending information for a sub-account. Returns the parent team's balance, the sub-account's total spending, and its credit limit (spending cap). Requires a parent project API key; sub-account API keys receive HTTP 403.
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubAccountGetBalanceResponse>
     *
     * @throws APIException
     */
    public function getBalance(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sub-accounts/%1$s/balance', $id],
            options: $requestOptions,
            convert: SubAccountGetBalanceResponse::class,
        );
    }
}
