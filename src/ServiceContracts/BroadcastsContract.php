<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Broadcasts\Broadcast;
use Zavudev\Broadcasts\BroadcastCancelResponse;
use Zavudev\Broadcasts\BroadcastChannel;
use Zavudev\Broadcasts\BroadcastContent;
use Zavudev\Broadcasts\BroadcastGetResponse;
use Zavudev\Broadcasts\BroadcastMessageType;
use Zavudev\Broadcasts\BroadcastNewResponse;
use Zavudev\Broadcasts\BroadcastProgress;
use Zavudev\Broadcasts\BroadcastRescheduleResponse;
use Zavudev\Broadcasts\BroadcastSendResponse;
use Zavudev\Broadcasts\BroadcastStatus;
use Zavudev\Broadcasts\BroadcastUpdateResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type BroadcastContentShape from \Zavudev\Broadcasts\BroadcastContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface BroadcastsContract
{
    /**
     * @api
     *
     * @param BroadcastChannel|value-of<BroadcastChannel> $channel Broadcast delivery channel. Use 'smart' for per-contact intelligent routing.
     * @param string $name name of the broadcast campaign
     * @param BroadcastContent|BroadcastContentShape $content content for non-text broadcast message types
     * @param string $emailHTMLBody HTML body for email broadcasts
     * @param string $emailSubject Email subject line. Required for email broadcasts.
     * @param string $idempotencyKey idempotency key to prevent duplicate broadcasts
     * @param BroadcastMessageType|value-of<BroadcastMessageType> $messageType type of message for broadcast
     * @param array<string,string> $metadata
     * @param \DateTimeInterface $scheduledAt schedule the broadcast for future delivery
     * @param string $senderID Sender profile ID. Uses default sender if omitted.
     * @param string $text Text content or caption. Supports template variables: {{name}}, {{1}}, etc.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        BroadcastChannel|string $channel,
        string $name,
        BroadcastContent|array|null $content = null,
        ?string $emailHTMLBody = null,
        ?string $emailSubject = null,
        ?string $idempotencyKey = null,
        BroadcastMessageType|string|null $messageType = null,
        ?array $metadata = null,
        ?\DateTimeInterface $scheduledAt = null,
        ?string $senderID = null,
        ?string $text = null,
        RequestOptions|array|null $requestOptions = null,
    ): BroadcastNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BroadcastGetResponse;

    /**
     * @api
     *
     * @param BroadcastContent|BroadcastContentShape $content content for non-text broadcast message types
     * @param array<string,string> $metadata
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $broadcastID,
        BroadcastContent|array|null $content = null,
        ?string $emailHTMLBody = null,
        ?string $emailSubject = null,
        ?array $metadata = null,
        ?string $name = null,
        ?string $text = null,
        RequestOptions|array|null $requestOptions = null,
    ): BroadcastUpdateResponse;

    /**
     * @api
     *
     * @param BroadcastStatus|value-of<BroadcastStatus> $status current status of the broadcast
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Broadcast>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        BroadcastStatus|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BroadcastCancelResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
    ): BroadcastProgress;

    /**
     * @api
     *
     * @param \DateTimeInterface $scheduledAt new scheduled time for the broadcast
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        \DateTimeInterface $scheduledAt,
        RequestOptions|array|null $requestOptions = null,
    ): BroadcastRescheduleResponse;

    /**
     * @api
     *
     * @param \DateTimeInterface $scheduledAt Schedule for future delivery. Omit to send immediately.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        ?\DateTimeInterface $scheduledAt = null,
        RequestOptions|array|null $requestOptions = null,
    ): BroadcastSendResponse;
}
