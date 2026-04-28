<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Broadcasts\Broadcast;
use Zavudev\Broadcasts\BroadcastCancelResponse;
use Zavudev\Broadcasts\BroadcastCreateParams;
use Zavudev\Broadcasts\BroadcastEscalateReviewResponse;
use Zavudev\Broadcasts\BroadcastGetResponse;
use Zavudev\Broadcasts\BroadcastListParams;
use Zavudev\Broadcasts\BroadcastNewResponse;
use Zavudev\Broadcasts\BroadcastProgress;
use Zavudev\Broadcasts\BroadcastRescheduleParams;
use Zavudev\Broadcasts\BroadcastRescheduleResponse;
use Zavudev\Broadcasts\BroadcastRetryReviewResponse;
use Zavudev\Broadcasts\BroadcastSendParams;
use Zavudev\Broadcasts\BroadcastSendResponse;
use Zavudev\Broadcasts\BroadcastUpdateParams;
use Zavudev\Broadcasts\BroadcastUpdateResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface BroadcastsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|BroadcastCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $broadcastID,
        array|BroadcastUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Broadcast>>
     *
     * @throws APIException
     */
    public function list(
        array|BroadcastListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastCancelResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastEscalateReviewResponse>
     *
     * @throws APIException
     */
    public function escalateReview(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastProgress>
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastRescheduleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastRescheduleResponse>
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        array|BroadcastRescheduleParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastRetryReviewResponse>
     *
     * @throws APIException
     */
    public function retryReview(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastSendResponse>
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        array|BroadcastSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
