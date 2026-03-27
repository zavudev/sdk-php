<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Messages\Channel;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageContent;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageStatus;
use Zavudev\Messages\MessageType;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface MessagesContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageID,
        RequestOptions|array|null $requestOptions = null
    ): MessageResponse;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
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
    ): MessageResponse;

    /**
     * @api
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
    ): MessageResponse;
}
