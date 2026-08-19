<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Conversations\ConversationGetResponse;
use Zavudev\Conversations\ConversationListMessagesParams;
use Zavudev\Conversations\ConversationListParams;
use Zavudev\Conversations\ConversationListParams\Channel;
use Zavudev\Conversations\ConversationListResponse;
use Zavudev\Conversations\ConversationMarkAsReadResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ConversationsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ConversationsRawService implements ConversationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get conversation
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ConversationGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/conversations/%1$s', $conversationID],
            options: $requestOptions,
            convert: ConversationGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List inbox threads, most recently active first. A conversation groups every message with one contact across channels, which is what you need to build an inbox: `GET /v1/messages` returns a flat log with no thread to hang it on.
     *
     * Use `senderId` to scope the list to a single number, and `channel` to keep only threads that have carried that channel.
     *
     * @param array{
     *   channel?: value-of<Channel>,
     *   cursor?: string,
     *   limit?: int,
     *   search?: string,
     *   senderID?: string,
     * }|ConversationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<ConversationListResponse>>
     *
     * @throws APIException
     */
    public function list(
        array|ConversationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConversationListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/conversations',
            query: Util::array_transform_keys($parsed, ['senderID' => 'senderId']),
            options: $options,
            convert: ConversationListResponse::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Messages in this thread, newest first, across every channel it has carried. Reply with `POST /v1/messages`, passing the conversation's `senderId` as the `Zavu-Sender` header so the answer leaves from the number the contact already knows.
     *
     * @param array{
     *   cursor?: string, limit?: int
     * }|ConversationListMessagesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Message>>
     *
     * @throws APIException
     */
    public function listMessages(
        string $conversationID,
        array|ConversationListMessagesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConversationListMessagesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/conversations/%1$s/messages', $conversationID],
            query: $parsed,
            options: $options,
            convert: Message::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Reset the thread's `unreadCount` to zero. Marks the thread read in your own inbox only: it does not send a read receipt to the contact.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ConversationMarkAsReadResponse>
     *
     * @throws APIException
     */
    public function markAsRead(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/conversations/%1$s/read', $conversationID],
            options: $requestOptions,
            convert: ConversationMarkAsReadResponse::class,
        );
    }
}
