<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Conversations\ConversationGetResponse;
use Zavudev\Conversations\ConversationListParams\Channel;
use Zavudev\Conversations\ConversationListResponse;
use Zavudev\Conversations\ConversationMarkAsReadResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ConversationsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ConversationsService implements ConversationsContract
{
    /**
     * @api
     */
    public ConversationsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ConversationsRawService($client);
    }

    /**
     * @api
     *
     * Get conversation
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): ConversationGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($conversationID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List inbox threads, most recently active first. A conversation groups every message with one contact across channels, which is what you need to build an inbox: `GET /v1/messages` returns a flat log with no thread to hang it on.
     *
     * Use `senderId` to scope the list to a single number, and `channel` to keep only threads that have carried that channel.
     *
     * @param Channel|value-of<Channel> $channel keep only threads that have carried this channel
     * @param string $cursor Opaque cursor from a previous response's `nextCursor`. Do not construct it.
     * @param string $search Search threads by identity: phone number (any format — `+1 (555) 123-4567` and `15551234567` both match), email address (full or local part), WhatsApp group subject, WhatsApp username, or BSUID. Matching is by whole word, with prefix matching on the last term, so `mar` finds `maria@example.com` and `+1555` finds `+15551234567`; a fragment from the middle or end of a number (`4567`) does not match.
     *
     * It does **not** search message bodies — only who the thread is with.
     *
     * Results come back ranked by relevance rather than by recency, so the usual "most recently active first" ordering does not apply while `q` is set. `senderId` and `channel` still narrow the results, and `cursor` paginates them as usual. An empty or whitespace-only `q` returns no items rather than the full list.
     * @param string $senderID keep only threads last handled by this sender
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<ConversationListResponse>
     *
     * @throws APIException
     */
    public function list(
        Channel|string|null $channel = null,
        ?string $cursor = null,
        int $limit = 50,
        ?string $search = null,
        ?string $senderID = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'cursor' => $cursor,
                'limit' => $limit,
                'search' => $search,
                'senderID' => $senderID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Messages in this thread, newest first, across every channel it has carried. Reply with `POST /v1/messages`, passing the conversation's `senderId` as the `Zavu-Sender` header so the answer leaves from the number the contact already knows.
     *
     * @param string $cursor opaque cursor from a previous response's `nextCursor`
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Message>
     *
     * @throws APIException
     */
    public function listMessages(
        string $conversationID,
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listMessages($conversationID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Reset the thread's `unreadCount` to zero. Marks the thread read in your own inbox only: it does not send a read receipt to the contact.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function markAsRead(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): ConversationMarkAsReadResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->markAsRead($conversationID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
