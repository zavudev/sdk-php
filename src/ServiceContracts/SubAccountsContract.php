<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
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
interface SubAccountsContract
{
    /**
     * @api
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
    ): SubAccountNewResponse;

    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): SubAccountGetResponse;

    /**
     * @api
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
    ): SubAccountUpdateResponse;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): SubAccountDeactivateResponse;

    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getBalance(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): SubAccountGetBalanceResponse;
}
