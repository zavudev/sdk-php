<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Channel;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageContent;
use Zavudev\Messages\MessageListParams;
use Zavudev\Messages\MessageReactParams;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageSendParams;
use Zavudev\Messages\MessageStatus;
use Zavudev\Messages\MessageType;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\MessagesRawContract;

/**
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class MessagesRawService implements MessagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get message by ID
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/%1$s', $messageID],
            options: $requestOptions,
            convert: MessageResponse::class,
        );
    }

    /**
     * @api
     *
     * List messages previously sent by this project.
     *
     * @param array{
     *   channel?: Channel|value-of<Channel>,
     *   cursor?: string,
     *   limit?: int,
     *   status?: MessageStatus|value-of<MessageStatus>,
     *   to?: string,
     * }|MessageListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Message>>
     *
     * @throws APIException
     */
    public function list(
        array|MessageListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/messages',
            query: $parsed,
            options: $options,
            convert: Message::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Send an emoji reaction to an existing WhatsApp message. Reactions are only supported for WhatsApp messages.
     *
     * @param string $messageID Path param
     * @param array{emoji: string, zavuSender?: string}|MessageReactParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function react(
        string $messageID,
        array|MessageReactParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageReactParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['zavuSender' => 'Zavu-Sender'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/messages/%1$s/reactions', $messageID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: MessageResponse::class,
        );
    }

    /**
     * @api
     *
     * Send a message to a recipient via SMS or WhatsApp.
     *
     * **Channel selection:**
     * - If `channel` is omitted and `messageType` is `text`, defaults to SMS
     * - If `messageType` is anything other than `text`, WhatsApp is used automatically
     *
     * **WhatsApp 24-hour window:**
     * - Free-form messages (non-template) require an open 24h window
     * - Window opens when the user messages you first
     * - Use template messages to initiate conversations outside the window
     *
     * @param array{
     *   to: string,
     *   channel?: Channel|value-of<Channel>,
     *   content?: MessageContent|MessageContentShape,
     *   fallbackEnabled?: bool,
     *   htmlBody?: string,
     *   idempotencyKey?: string,
     *   messageType?: value-of<MessageType>,
     *   metadata?: array<string,string>,
     *   replyTo?: string,
     *   subject?: string,
     *   text?: string,
     *   zavuSender?: string,
     * }|MessageSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function send(
        array|MessageSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageSendParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['zavuSender' => 'Zavu-Sender'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: MessageResponse::class,
        );
    }
}
