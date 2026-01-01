<?php

declare(strict_types=1);

namespace Zavudev\Services;

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
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\BroadcastsContract;
use Zavudev\Services\Broadcasts\ContactsService;

final class BroadcastsService implements BroadcastsContract
{
    /**
     * @api
     */
    public BroadcastsRawService $raw;

    /**
     * @api
     */
    public ContactsService $contacts;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BroadcastsRawService($client);
        $this->contacts = new ContactsService($client);
    }

    /**
     * @api
     *
     * Create a new broadcast campaign. Add contacts after creation, then send.
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
    ): BroadcastNewResponse {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'name' => $name,
                'content' => $content,
                'emailHTMLBody' => $emailHTMLBody,
                'emailSubject' => $emailSubject,
                'idempotencyKey' => $idempotencyKey,
                'messageType' => $messageType,
                'metadata' => $metadata,
                'scheduledAt' => $scheduledAt,
                'senderID' => $senderID,
                'text' => $text,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get broadcast
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BroadcastGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($broadcastID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a broadcast in draft status.
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
    ): BroadcastUpdateResponse {
        $params = Util::removeNulls(
            [
                'content' => $content,
                'emailHTMLBody' => $emailHTMLBody,
                'emailSubject' => $emailSubject,
                'metadata' => $metadata,
                'name' => $name,
                'text' => $text,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($broadcastID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List broadcasts for this project.
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
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a broadcast in draft status.
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($broadcastID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Cancel a broadcast. Pending contacts will be skipped, but already queued messages may still be delivered.
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BroadcastCancelResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->cancel($broadcastID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get real-time progress of a broadcast including delivery counts and estimated completion time.
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        ?RequestOptions $requestOptions = null
    ): BroadcastProgress {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->progress($broadcastID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update the scheduled time for a broadcast. The broadcast must be in scheduled status.
     *
     * @param string|\DateTimeInterface $scheduledAt new scheduled time for the broadcast
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        string|\DateTimeInterface $scheduledAt,
        ?RequestOptions $requestOptions = null,
    ): BroadcastRescheduleResponse {
        $params = Util::removeNulls(['scheduledAt' => $scheduledAt]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->reschedule($broadcastID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Start sending the broadcast immediately or schedule for later. Reserves the estimated cost from your balance.
     *
     * @param string|\DateTimeInterface $scheduledAt Schedule for future delivery. Omit to send immediately.
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        string|\DateTimeInterface|null $scheduledAt = null,
        ?RequestOptions $requestOptions = null,
    ): BroadcastSendResponse {
        $params = Util::removeNulls(['scheduledAt' => $scheduledAt]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->send($broadcastID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
