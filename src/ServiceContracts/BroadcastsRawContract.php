<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Broadcasts\Broadcast;
use Zavudev\Broadcasts\BroadcastCancelResponse;
use Zavudev\Broadcasts\BroadcastCreateParams;
use Zavudev\Broadcasts\BroadcastGetResponse;
use Zavudev\Broadcasts\BroadcastListParams;
use Zavudev\Broadcasts\BroadcastNewResponse;
use Zavudev\Broadcasts\BroadcastProgress;
use Zavudev\Broadcasts\BroadcastRescheduleParams;
use Zavudev\Broadcasts\BroadcastRescheduleResponse;
use Zavudev\Broadcasts\BroadcastSendParams;
use Zavudev\Broadcasts\BroadcastSendResponse;
use Zavudev\Broadcasts\BroadcastUpdateParams;
use Zavudev\Broadcasts\BroadcastUpdateResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface BroadcastsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastCreateParams $params
     *
     * @return BaseResponse<BroadcastNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|BroadcastCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<BroadcastGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastUpdateParams $params
     *
     * @return BaseResponse<BroadcastUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $broadcastID,
        array|BroadcastUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastListParams $params
     *
     * @return BaseResponse<Cursor<Broadcast>>
     *
     * @throws APIException
     */
    public function list(
        array|BroadcastListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<BroadcastCancelResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<BroadcastProgress>
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastRescheduleParams $params
     *
     * @return BaseResponse<BroadcastRescheduleResponse>
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        array|BroadcastRescheduleParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastSendParams $params
     *
     * @return BaseResponse<BroadcastSendResponse>
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        array|BroadcastSendParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
