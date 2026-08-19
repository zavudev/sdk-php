<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageContent;
use Zavudev\Messages\MessageListAttachmentsResponse;
use Zavudev\Messages\MessageListParams\Channel;
use Zavudev\Messages\MessageListParams\Status;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageSendParams\Attachment;
use Zavudev\Messages\MessageShowTypingResponse;
use Zavudev\Messages\MessageType;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\MessagesContract;

/**
 * @phpstan-import-type AttachmentShape from \Zavudev\Messages\MessageSendParams\Attachment
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
     * @param Channel|value-of<Channel> $channel filter by delivery channel
     * @param Status|value-of<Status> $status Filter by status. Not all stored statuses are filterable.
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
        Status|string|null $status = null,
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
     * List the stored file attachments for an email message and get a short-lived signed `downloadUrl` for each. Works for both inbound emails (received via `message.inbound`) and outbound emails you sent with attachments. Messages without stored attachments (including SMS, WhatsApp, and other channels) return an empty list. Each `downloadUrl` is generated fresh per request and expires — fetch the file promptly and do not cache the URL.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listAttachments(
        string $messageID,
        RequestOptions|array|null $requestOptions = null
    ): MessageListAttachmentsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listAttachments($messageID, requestOptions: $requestOptions);

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
     * **Plan allowances and email billing:**
     * - WhatsApp, Telegram, Instagram and Messenger share an allowance of 2,000 messages per month on Free. Over it, sends return 429 with code `a2p_limit_exceeded` and upgrade details; the counter resets on the 1st of each month. Paid plans have no message caps
     * - Email is billed from your prepaid balance in 1,000-message blocks: $0.40 per 1,000 transactional emails, $0.80 per 1,000 marketing (broadcast) emails. A block is charged when your monthly count crosses each 1,000 boundary, and at zero balance email sends return 402 with code `insufficient_balance`. Free teams start with $2 of credit and additionally cap at 3,000 emails/month and 100/day. Teams on earlier plans keep their original email quotas instead
     * - SMS and voice are billed per message from your balance on every plan
     *
     * **Email recipient pre-flight:**
     * Email messages are validated automatically before dispatch. Sends that would be a guaranteed hard bounce are failed instead of sent, protecting your bounce rate: the message transitions to `failed` (visible via `GET /v1/messages/{messageId}` and the `message.failed` webhook) with `errorCode` set to `EMAIL_INVALID_RECIPIENT` (malformed address), `EMAIL_DOMAIN_NOT_FOUND` (recipient domain has no MX or A records), or `EMAIL_RECIPIENT_SUPPRESSED` (address is on your suppression list after a previous bounce or complaint). Advisory signals (role addresses, disposable domains) do not block sends — check them beforehand with `POST /v1/introspect/email`.
     *
     * @param string $to Body param: Recipient phone number in E.164 format, email address, WhatsApp business-scoped user ID (BSUID, e.g. `US.13491208655302741918`), or numeric chat ID (for Telegram/Instagram/Messenger). A BSUID is routed to WhatsApp and sent via the `recipient` field; use it to message a contact who adopted a username and whose phone number is hidden.
     * @param list<Attachment|AttachmentShape> $attachments Body param: Email attachments. Only supported when channel is 'email'. Maximum 40MB total size.
     * @param \Zavudev\Messages\Channel|value-of<\Zavudev\Messages\Channel> $channel Body param: Delivery channel. Use 'auto' for intelligent routing. If omitted, channel is auto-selected based on sender capabilities and recipient type. For email recipients, defaults to 'email'.
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
        ?array $attachments = null,
        \Zavudev\Messages\Channel|string|null $channel = null,
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
                'attachments' => $attachments,
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

    /**
     * @api
     *
     * Mark an inbound WhatsApp message as read and display a typing indicator to the user while you prepare a response. The indicator is automatically dismissed when you send a reply, or after 25 seconds — whichever comes first. Only valid for inbound WhatsApp messages. Use this when a reply will take more than a couple of seconds (LLM agent, tool call, lookup) to improve the recipient's experience.
     *
     * @param string $zavuSender Optional sender profile ID. If omitted, the project's default sender will be used.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function showTyping(
        string $messageID,
        ?string $zavuSender = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageShowTypingResponse {
        $params = Util::removeNulls(['zavuSender' => $zavuSender]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->showTyping($messageID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
