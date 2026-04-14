<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\SubAccounts\SubAccount;
use Zavudev\SubAccounts\SubAccountCreateParams;
use Zavudev\SubAccounts\SubAccountDeactivateResponse;
use Zavudev\SubAccounts\SubAccountGetBalanceResponse;
use Zavudev\SubAccounts\SubAccountGetResponse;
use Zavudev\SubAccounts\SubAccountListParams;
use Zavudev\SubAccounts\SubAccountNewResponse;
use Zavudev\SubAccounts\SubAccountUpdateParams;
use Zavudev\SubAccounts\SubAccountUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SubAccountsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SubAccountCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubAccountNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SubAccountCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id sub-account ID
     * @param array<string,mixed>|SubAccountUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SubAccountListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<SubAccount>>
     *
     * @throws APIException
     */
    public function list(
        array|SubAccountListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
