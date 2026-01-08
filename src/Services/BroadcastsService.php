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

/**
 * @phpstan-import-type BroadcastContentShape from \Zavudev\Broadcasts\BroadcastContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function progress(
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null
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
     * @param \DateTimeInterface $scheduledAt new scheduled time for the broadcast
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reschedule(
        string $broadcastID,
        \DateTimeInterface $scheduledAt,
        RequestOptions|array|null $requestOptions = null,
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
     * @param \DateTimeInterface $scheduledAt Schedule for future delivery. Omit to send immediately.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        string $broadcastID,
        ?\DateTimeInterface $scheduledAt = null,
        RequestOptions|array|null $requestOptions = null,
    ): BroadcastSendResponse {
        $params = Util::removeNulls(['scheduledAt' => $scheduledAt]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->send($broadcastID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
