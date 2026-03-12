<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Channel;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageContent;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageStatus;
use Zavudev\Messages\MessageType;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\MessagesContract;

/**
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public MessagesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MessagesRawService($client);
    }

    /**
     * @api
     *
     * Get message by ID
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageID,
        RequestOptions|array|null $requestOptions = null
    ): MessageResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($messageID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List messages previously sent by this project.
     *
     * @param Channel|value-of<Channel> $channel Delivery channel. Use 'auto' for intelligent routing.
     * @param MessageStatus|value-of<MessageStatus> $status
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Message>
     *
     * @throws APIException
     */
    public function list(
        Channel|string|null $channel = null,
        ?string $cursor = null,
        int $limit = 50,
        MessageStatus|string|null $status = null,
        ?string $to = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'cursor' => $cursor,
                'limit' => $limit,
                'status' => $status,
                'to' => $to,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Send an emoji reaction to an existing WhatsApp message. Reactions are only supported for WhatsApp messages.
     *
     * @param string $messageID Path param
     * @param string $emoji body param: Single emoji character to react with
     * @param string $zavuSender Header param: Optional sender profile ID. If omitted, the project's default sender will be used.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function react(
        string $messageID,
        string $emoji,
        ?string $zavuSender = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageResponse {
        $params = Util::removeNulls(
            ['emoji' => $emoji, 'zavuSender' => $zavuSender]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->react($messageID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * **Daily limits:**
     * - Unverified accounts: 200 messages per channel per day
     * - Complete KYC verification to increase limits to 10,000/day
     *
     * @param string $to Body param: Recipient phone number in E.164 format, email address, or numeric chat ID (for Telegram/Instagram).
     * @param Channel|value-of<Channel> $channel Body param: Delivery channel. Use 'auto' for intelligent routing. If omitted with non-text messageType, WhatsApp is used. For email recipients, defaults to 'email'.
     * @param MessageContent|MessageContentShape $content body param: Additional content for non-text message types
     * @param bool $fallbackEnabled Body param: Whether to enable automatic fallback to SMS if WhatsApp fails. Defaults to true.
     * @param string $htmlBody Body param: HTML body for email messages. If provided, email will be sent as multipart with both text and HTML.
     * @param string $idempotencyKey body param: Optional idempotency key to avoid duplicate sends
     * @param MessageType|value-of<MessageType> $messageType Body param: Type of message. Defaults to 'text'.
     * @param array<string,string> $metadata body param: Arbitrary metadata to associate with the message
     * @param string $replyTo body param: Reply-To email address for email messages
     * @param string $subject Body param: Email subject line. Required when channel is 'email' or recipient is an email address.
     * @param string $text body param: Text body for text messages or caption for media messages
     * @param string $voiceLanguage Body param: Language code for voice text-to-speech (e.g., 'en-US', 'es-ES', 'pt-BR'). If omitted, language is auto-detected from recipient's country code.
     * @param string $zavuSender Header param: Optional sender profile ID. If omitted, the project's default sender will be used.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        string $to,
        Channel|string|null $channel = null,
        MessageContent|array|null $content = null,
        bool $fallbackEnabled = true,
        ?string $htmlBody = null,
        ?string $idempotencyKey = null,
        MessageType|string|null $messageType = null,
        ?array $metadata = null,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $text = null,
        ?string $voiceLanguage = null,
        ?string $zavuSender = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageResponse {
        $params = Util::removeNulls(
            [
                'to' => $to,
                'channel' => $channel,
                'content' => $content,
                'fallbackEnabled' => $fallbackEnabled,
                'htmlBody' => $htmlBody,
                'idempotencyKey' => $idempotencyKey,
                'messageType' => $messageType,
                'metadata' => $metadata,
                'replyTo' => $replyTo,
                'subject' => $subject,
                'text' => $text,
                'voiceLanguage' => $voiceLanguage,
                'zavuSender' => $zavuSender,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->send(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
