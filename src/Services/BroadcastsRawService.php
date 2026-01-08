<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Broadcasts\Broadcast;
use Zavudev\Broadcasts\BroadcastCancelResponse;
use Zavudev\Broadcasts\BroadcastChannel;
use Zavudev\Broadcasts\BroadcastContent;
use Zavudev\Broadcasts\BroadcastCreateParams;
use Zavudev\Broadcasts\BroadcastGetResponse;
use Zavudev\Broadcasts\BroadcastListParams;
use Zavudev\Broadcasts\BroadcastMessageType;
use Zavudev\Broadcasts\BroadcastNewResponse;
use Zavudev\Broadcasts\BroadcastProgress;
use Zavudev\Broadcasts\BroadcastRescheduleParams;
use Zavudev\Broadcasts\BroadcastRescheduleResponse;
use Zavudev\Broadcasts\BroadcastSendParams;
use Zavudev\Broadcasts\BroadcastSendResponse;
use Zavudev\Broadcasts\BroadcastStatus;
use Zavudev\Broadcasts\BroadcastUpdateParams;
use Zavudev\Broadcasts\BroadcastUpdateResponse;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\BroadcastsRawContract;

/**
 * @phpstan-import-type BroadcastContentShape from \Zavudev\Broadcasts\BroadcastContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class BroadcastsRawService implements BroadcastsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new broadcast campaign. Add contacts after creation, then send.
     *
     * @param array{
     *   channel: BroadcastChannel|value-of<BroadcastChannel>,
     *   name: string,
     *   content?: BroadcastContent|BroadcastContentShape,
     *   emailHTMLBody?: string,
     *   emailSubject?: string,
     *   idempotencyKey?: string,
     *   messageType?: BroadcastMessageType|value-of<BroadcastMessageType>,
     *   metadata?: array<string,string>,
     *   scheduledAt?: \DateTimeInterface,
     *   senderID?: string,
     *   text?: string,
     * }|BroadcastCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|BroadcastCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BroadcastCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/broadcasts',
            body: (object) $parsed,
            options: $options,
            convert: BroadcastNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get broadcast
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/broadcasts/%1$s', $broadcastID],
            options: $requestOptions,
            convert: BroadcastGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a broadcast in draft status.
     *
     * @param array{
     *   content?: BroadcastContent|BroadcastContentShape,
     *   emailHTMLBody?: string,
     *   emailSubject?: string,
     *   metadata?: array<string,string>,
     *   name?: string,
     *   text?: string,
     * }|BroadcastUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BroadcastUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/broadcasts/%1$s', $broadcastID],
            body: (object) $parsed,
            options: $options,
            convert: BroadcastUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List broadcasts for this project.
     *
     * @param array{
     *   cursor?: string,
     *   limit?: int,
     *   status?: BroadcastStatus|value-of<BroadcastStatus>,
     * }|BroadcastListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Broadcast>>
     *
     * @throws APIException
     */
    public function list(
        array|BroadcastListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BroadcastListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/broadcasts',
            query: $parsed,
            options: $options,
            convert: Broadcast::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a broadcast in draft status.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/broadcasts/%1$s', $broadcastID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Cancel a broadcast. Pending contacts will be skipped, but already queued messages may still be delivered.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/broadcasts/%1$s/cancel', $broadcastID],
            options: $requestOptions,
            convert: BroadcastCancelResponse::class,
        );
    }

    /**
     * @api
     *
     * Get real-time progress of a broadcast including delivery counts and estimated completion time.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/broadcasts/%1$s/progress', $broadcastID],
            options: $requestOptions,
            convert: BroadcastProgress::class,
        );
    }

    /**
     * @api
     *
     * Update the scheduled time for a broadcast. The broadcast must be in scheduled status.
     *
     * @param array{scheduledAt: \DateTimeInterface}|BroadcastRescheduleParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BroadcastRescheduleParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/broadcasts/%1$s/schedule', $broadcastID],
            body: (object) $parsed,
            options: $options,
            convert: BroadcastRescheduleResponse::class,
        );
    }

    /**
     * @api
     *
     * Start sending the broadcast immediately or schedule for later. Reserves the estimated cost from your balance.
     *
     * @param array{scheduledAt?: \DateTimeInterface}|BroadcastSendParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BroadcastSendParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/broadcasts/%1$s/send', $broadcastID],
            body: (object) $parsed,
            options: $options,
            convert: BroadcastSendResponse::class,
        );
    }
}
