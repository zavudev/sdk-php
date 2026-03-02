<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
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
 * **Email requirements:**
 * - Email channel requires KYC verification. Complete identity verification in the dashboard before sending emails.
 *
 * @see Zavudev\Services\MessagesService::send()
 *
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 *
 * @phpstan-type MessageSendParamsShape = array{
 *   to: string,
 *   channel?: null|Channel|value-of<Channel>,
 *   content?: null|MessageContent|MessageContentShape,
 *   fallbackEnabled?: bool|null,
 *   htmlBody?: string|null,
 *   idempotencyKey?: string|null,
 *   messageType?: null|MessageType|value-of<MessageType>,
 *   metadata?: array<string,string>|null,
 *   replyTo?: string|null,
 *   subject?: string|null,
 *   text?: string|null,
 *   voiceLanguage?: string|null,
 *   zavuSender?: string|null,
 * }
 */
final class MessageSendParams implements BaseModel
{
    /** @use SdkModel<MessageSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Recipient phone number in E.164 format or email address.
     */
    #[Required]
    public string $to;

    /**
     * Delivery channel. Use 'auto' for intelligent routing. If omitted with non-text messageType, WhatsApp is used. For email recipients, defaults to 'email'.
     *
     * @var value-of<Channel>|null $channel
     */
    #[Optional(enum: Channel::class)]
    public ?string $channel;

    /**
     * Additional content for non-text message types.
     */
    #[Optional]
    public ?MessageContent $content;

    /**
     * Whether to enable automatic fallback to SMS if WhatsApp fails. Defaults to true.
     */
    #[Optional]
    public ?bool $fallbackEnabled;

    /**
     * HTML body for email messages. If provided, email will be sent as multipart with both text and HTML.
     */
    #[Optional]
    public ?string $htmlBody;

    /**
     * Optional idempotency key to avoid duplicate sends.
     */
    #[Optional]
    public ?string $idempotencyKey;

    /**
     * Type of message. Defaults to 'text'.
     *
     * @var value-of<MessageType>|null $messageType
     */
    #[Optional(enum: MessageType::class)]
    public ?string $messageType;

    /**
     * Arbitrary metadata to associate with the message.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Reply-To email address for email messages.
     */
    #[Optional]
    public ?string $replyTo;

    /**
     * Email subject line. Required when channel is 'email' or recipient is an email address.
     */
    #[Optional]
    public ?string $subject;

    /**
     * Text body for text messages or caption for media messages.
     */
    #[Optional]
    public ?string $text;

    /**
     * Language code for voice text-to-speech (e.g., 'en-US', 'es-ES', 'pt-BR'). If omitted, language is auto-detected from recipient's country code.
     */
    #[Optional]
    public ?string $voiceLanguage;

    #[Optional]
    public ?string $zavuSender;

    /**
     * `new MessageSendParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageSendParams::with(to: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageSendParams)->withTo(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Channel|value-of<Channel>|null $channel
     * @param MessageContent|MessageContentShape|null $content
     * @param MessageType|value-of<MessageType>|null $messageType
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $to,
        Channel|string|null $channel = null,
        MessageContent|array|null $content = null,
        ?bool $fallbackEnabled = null,
        ?string $htmlBody = null,
        ?string $idempotencyKey = null,
        MessageType|string|null $messageType = null,
        ?array $metadata = null,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $text = null,
        ?string $voiceLanguage = null,
        ?string $zavuSender = null,
    ): self {
        $self = new self;

        $self['to'] = $to;

        null !== $channel && $self['channel'] = $channel;
        null !== $content && $self['content'] = $content;
        null !== $fallbackEnabled && $self['fallbackEnabled'] = $fallbackEnabled;
        null !== $htmlBody && $self['htmlBody'] = $htmlBody;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $messageType && $self['messageType'] = $messageType;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $replyTo && $self['replyTo'] = $replyTo;
        null !== $subject && $self['subject'] = $subject;
        null !== $text && $self['text'] = $text;
        null !== $voiceLanguage && $self['voiceLanguage'] = $voiceLanguage;
        null !== $zavuSender && $self['zavuSender'] = $zavuSender;

        return $self;
    }

    /**
     * Recipient phone number in E.164 format or email address.
     */
    public function withTo(string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Delivery channel. Use 'auto' for intelligent routing. If omitted with non-text messageType, WhatsApp is used. For email recipients, defaults to 'email'.
     *
     * @param Channel|value-of<Channel> $channel
     */
    public function withChannel(Channel|string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Additional content for non-text message types.
     *
     * @param MessageContent|MessageContentShape $content
     */
    public function withContent(MessageContent|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Whether to enable automatic fallback to SMS if WhatsApp fails. Defaults to true.
     */
    public function withFallbackEnabled(bool $fallbackEnabled): self
    {
        $self = clone $this;
        $self['fallbackEnabled'] = $fallbackEnabled;

        return $self;
    }

    /**
     * HTML body for email messages. If provided, email will be sent as multipart with both text and HTML.
     */
    public function withHTMLBody(string $htmlBody): self
    {
        $self = clone $this;
        $self['htmlBody'] = $htmlBody;

        return $self;
    }

    /**
     * Optional idempotency key to avoid duplicate sends.
     */
    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Type of message. Defaults to 'text'.
     *
     * @param MessageType|value-of<MessageType> $messageType
     */
    public function withMessageType(MessageType|string $messageType): self
    {
        $self = clone $this;
        $self['messageType'] = $messageType;

        return $self;
    }

    /**
     * Arbitrary metadata to associate with the message.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Reply-To email address for email messages.
     */
    public function withReplyTo(string $replyTo): self
    {
        $self = clone $this;
        $self['replyTo'] = $replyTo;

        return $self;
    }

    /**
     * Email subject line. Required when channel is 'email' or recipient is an email address.
     */
    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }

    /**
     * Text body for text messages or caption for media messages.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Language code for voice text-to-speech (e.g., 'en-US', 'es-ES', 'pt-BR'). If omitted, language is auto-detected from recipient's country code.
     */
    public function withVoiceLanguage(string $voiceLanguage): self
    {
        $self = clone $this;
        $self['voiceLanguage'] = $voiceLanguage;

        return $self;
    }

    public function withZavuSender(string $zavuSender): self
    {
        $self = clone $this;
        $self['zavuSender'] = $zavuSender;

        return $self;
    }
}
