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

interface MessagesContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageID,
        ?RequestOptions $requestOptions = null
    ): MessageResponse;

    /**
     * @api
     *
     * @param 'auto'|'sms'|'whatsapp'|'email'|Channel $channel Delivery channel. Use 'auto' for intelligent routing.
     * @param 'queued'|'sending'|'delivered'|'failed'|'received'|MessageStatus $status
     *
     * @return Cursor<Message>
     *
     * @throws APIException
     */
    public function list(
        string|Channel|null $channel = null,
        ?string $cursor = null,
        int $limit = 50,
        string|MessageStatus|null $status = null,
        ?string $to = null,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param string $messageID Path param:
     * @param string $emoji body param: Single emoji character to react with
     * @param string $zavuSender Header param: Optional sender profile ID. If omitted, the project's default sender will be used.
     *
     * @throws APIException
     */
    public function react(
        string $messageID,
        string $emoji,
        ?string $zavuSender = null,
        ?RequestOptions $requestOptions = null,
    ): MessageResponse;

    /**
     * @api
     *
     * @param string $to Body param: Recipient phone number in E.164 format or email address.
     * @param 'auto'|'sms'|'whatsapp'|'email'|Channel $channel Body param: Delivery channel. Use 'auto' for intelligent routing. If omitted with non-text messageType, WhatsApp is used. For email recipients, defaults to 'email'.
     * @param array{
     *   buttons?: list<array{id: string, title: string}>,
     *   contacts?: list<array{name?: string, phones?: list<string>}>,
     *   emoji?: string,
     *   filename?: string,
     *   latitude?: float,
     *   listButton?: string,
     *   locationAddress?: string,
     *   locationName?: string,
     *   longitude?: float,
     *   mediaID?: string,
     *   mediaURL?: string,
     *   mimeType?: string,
     *   reactToMessageID?: string,
     *   sections?: list<array{
     *     rows: list<array{id: string, title: string, description?: string}>,
     *     title: string,
     *   }>,
     *   templateID?: string,
     *   templateVariables?: array<string,string>,
     * }|MessageContent $content Body param: Additional content for non-text message types
     * @param bool $fallbackEnabled Body param: Whether to enable automatic fallback to SMS if WhatsApp fails. Defaults to true.
     * @param string $htmlBody Body param: HTML body for email messages. If provided, email will be sent as multipart with both text and HTML.
     * @param string $idempotencyKey body param: Optional idempotency key to avoid duplicate sends
     * @param 'text'|'image'|'video'|'audio'|'document'|'sticker'|'location'|'contact'|'buttons'|'list'|'reaction'|'template'|MessageType $messageType Body param: Type of message. Defaults to 'text'.
     * @param array<string,string> $metadata body param: Arbitrary metadata to associate with the message
     * @param string $replyTo body param: Reply-To email address for email messages
     * @param string $subject Body param: Email subject line. Required when channel is 'email' or recipient is an email address.
     * @param string $text body param: Text body for text messages or caption for media messages
     * @param string $zavuSender Header param: Optional sender profile ID. If omitted, the project's default sender will be used.
     *
     * @throws APIException
     */
    public function send(
        string $to,
        string|Channel|null $channel = null,
        array|MessageContent|null $content = null,
        bool $fallbackEnabled = true,
        ?string $htmlBody = null,
        ?string $idempotencyKey = null,
        string|MessageType|null $messageType = null,
        ?array $metadata = null,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $text = null,
        ?string $zavuSender = null,
        ?RequestOptions $requestOptions = null,
    ): MessageResponse;
}
