<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Conversations\ConversationGetResponse;
use Zavudev\Conversations\ConversationListParams\Channel;
use Zavudev\Conversations\ConversationListResponse;
use Zavudev\Conversations\ConversationMarkAsReadResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ConversationsContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): ConversationGetResponse;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function markAsRead(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): ConversationMarkAsReadResponse;
}
