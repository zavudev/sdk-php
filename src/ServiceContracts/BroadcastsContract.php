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

interface BroadcastsContract
{
    /**
     * @api
     *
     * @param 'smart'|'sms'|'whatsapp'|'email'|BroadcastChannel $channel Broadcast delivery channel. Use 'smart' for per-contact intelligent routing.
     * @param string $name name of the broadcast campaign
     * @param array{
     *   filename?: string,
     *   mediaID?: string,
     *   mediaURL?: string,
     *   mimeType?: string,
     *   templateID?: string,
     *   templateVariables?: array<string,string>,
     * }|BroadcastContent $content Content for non-text broadcast message types
     * @param string $emailHTMLBody HTML body for email broadcasts
     * @param string $emailSubject Email subject line. Required for email broadcasts.
     * @param string $idempotencyKey idempotency key to prevent duplicate broadcasts
     * @param 'text'|'image'|'video'|'audio'|'document'|'template'|BroadcastMessageType $messageType type of message for broadcast
     * @param array<string,string> $metadata
     * @param string|\DateTimeInterface $scheduledAt schedule the broadcast for future delivery
     * @param string $senderID Sender profile ID. Uses default sender if omitted.
     * @param string $text Text content or caption. Supports template variables: {{name}}, {{1}}, etc.
     *
     * @throws APIException
     */
    public function create(
        string|BroadcastChannel $channel,
        string $name,
        array|BroadcastContent|null $content = null,
        ?string $emailHTMLBody = null,
        ?string $emailSubject = null,
        ?string $idempotencyKey = null,
        string|BroadcastMessageType|null $messageType = null,
        ?array $metadata = null,
        string|\DateTimeInterface|null $scheduledAt = null,
        ?string $senderID = null,
        ?string $text = null,
        ?RequestOptions $requestOptions = null,
    ): BroadcastNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BroadcastGetResponse;

    /**
     * @api
     *
     * @param array{
     *   filename?: string,
     *   mediaID?: string,
     *   mediaURL?: string,
     *   mimeType?: string,
     *   templateID?: string,
     *   templateVariables?: array<string,string>,
     * }|BroadcastContent $content Content for non-text broadcast message types
     * @param array<string,string> $metadata
     *
     * @throws APIException
     */
    public function update(
        string $broadcastID,
        array|BroadcastContent|null $content = null,
        ?string $emailHTMLBody = null,
        ?string $emailSubject = null,
        ?array $metadata = null,
        ?string $name = null,
        ?string $text = null,
        ?RequestOptions $requestOptions = null,
    ): BroadcastUpdateResponse;

    /**
     * @api
     *
     * @param 'draft'|'scheduled'|'sending'|'paused'|'completed'|'cancelled'|'failed'|BroadcastStatus $status current status of the broadcast
     *
     * @return Cursor<Broadcast>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        string|BroadcastStatus|null $status = null,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BroadcastCancelResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BroadcastProgress;

    /**
     * @api
     *
     * @param string|\DateTimeInterface $scheduledAt new scheduled time for the broadcast
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        string|\DateTimeInterface $scheduledAt,
        ?RequestOptions $requestOptions = null,
    ): BroadcastRescheduleResponse;

    /**
     * @api
     *
     * @param string|\DateTimeInterface $scheduledAt Schedule for future delivery. Omit to send immediately.
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        string|\DateTimeInterface|null $scheduledAt = null,
        ?RequestOptions $requestOptions = null,
    ): BroadcastSendResponse;
}
