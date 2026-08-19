<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Calls\CallCreateParams;
use Zavudev\Calls\CallGetResponse;
use Zavudev\Calls\CallHangupResponse;
use Zavudev\Calls\CallListParams;
use Zavudev\Calls\CallListResponse;
use Zavudev\Calls\CallNewResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface CallsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CallCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CallCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CallListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<CallListResponse>>
     *
     * @throws APIException
     */
    public function list(
        array|CallListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $callID voice call ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CallHangupResponse>
     *
     * @throws APIException
     */
    public function hangup(
        string $callID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
