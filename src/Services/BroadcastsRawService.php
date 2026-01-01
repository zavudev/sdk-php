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
     *   channel: 'smart'|'sms'|'whatsapp'|'email'|BroadcastChannel,
     *   name: string,
     *   content?: array{
     *     filename?: string,
     *     mediaID?: string,
     *     mediaURL?: string,
     *     mimeType?: string,
     *     templateID?: string,
     *     templateVariables?: array<string,string>,
     *   }|BroadcastContent,
     *   emailHTMLBody?: string,
     *   emailSubject?: string,
     *   idempotencyKey?: string,
     *   messageType?: 'text'|'image'|'video'|'audio'|'document'|'template'|BroadcastMessageType,
     *   metadata?: array<string,string>,
     *   scheduledAt?: string|\DateTimeInterface,
     *   senderID?: string,
     *   text?: string,
     * }|BroadcastCreateParams $params
     *
     * @return BaseResponse<BroadcastNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|BroadcastCreateParams $params,
        ?RequestOptions $requestOptions = null
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
     * @return BaseResponse<BroadcastGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
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
     *   content?: array{
     *     filename?: string,
     *     mediaID?: string,
     *     mediaURL?: string,
     *     mimeType?: string,
     *     templateID?: string,
     *     templateVariables?: array<string,string>,
     *   }|BroadcastContent,
     *   emailHTMLBody?: string,
     *   emailSubject?: string,
     *   metadata?: array<string,string>,
     *   name?: string,
     *   text?: string,
     * }|BroadcastUpdateParams $params
     *
     * @return BaseResponse<BroadcastUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $broadcastID,
        array|BroadcastUpdateParams $params,
        ?RequestOptions $requestOptions = null,
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
     *   status?: 'draft'|'scheduled'|'sending'|'paused'|'completed'|'cancelled'|'failed'|BroadcastStatus,
     * }|BroadcastListParams $params
     *
     * @return BaseResponse<Cursor<Broadcast>>
     *
     * @throws APIException
     */
    public function list(
        array|BroadcastListParams $params,
        ?RequestOptions $requestOptions = null
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
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
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
     * @return BaseResponse<BroadcastCancelResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
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
     * @return BaseResponse<BroadcastProgress>
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
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
     * @param array{
     *   scheduledAt: string|\DateTimeInterface
     * }|BroadcastRescheduleParams $params
     *
     * @return BaseResponse<BroadcastRescheduleResponse>
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        array|BroadcastRescheduleParams $params,
        ?RequestOptions $requestOptions = null,
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
     * @param array{
     *   scheduledAt?: string|\DateTimeInterface
     * }|BroadcastSendParams $params
     *
     * @return BaseResponse<BroadcastSendResponse>
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        array|BroadcastSendParams $params,
        ?RequestOptions $requestOptions = null,
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
