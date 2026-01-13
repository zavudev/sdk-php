<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 *
 * @phpstan-type MessageShape = array{
 *   id: string,
 *   channel: Channel|value-of<Channel>,
 *   createdAt: \DateTimeInterface,
 *   messageType: MessageType|value-of<MessageType>,
 *   status: MessageStatus|value-of<MessageStatus>,
 *   to: string,
 *   content?: null|MessageContent|MessageContentShape,
 *   cost?: float|null,
 *   costProvider?: float|null,
 *   costTotal?: float|null,
 *   errorCode?: string|null,
 *   errorMessage?: string|null,
 *   from?: string|null,
 *   metadata?: array<string,string>|null,
 *   providerMessageID?: string|null,
 *   senderID?: string|null,
 *   text?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Message implements BaseModel
{
    /** @use SdkModel<MessageShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Delivery channel. Use 'auto' for intelligent routing.
     *
     * @var value-of<Channel> $channel
     */
    #[Required(enum: Channel::class)]
    public string $channel;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Type of message. Non-text types are supported by WhatsApp and Telegram (varies by type).
     *
     * @var value-of<MessageType> $messageType
     */
    #[Required(enum: MessageType::class)]
    public string $messageType;

    /** @var value-of<MessageStatus> $status */
    #[Required(enum: MessageStatus::class)]
    public string $status;

    #[Required]
    public string $to;

    /**
     * Content for non-text message types (WhatsApp and Telegram).
     */
    #[Optional]
    public ?MessageContent $content;

    /**
     * MAU cost in USD (charged for first contact of the month).
     */
    #[Optional(nullable: true)]
    public ?float $cost;

    /**
     * Provider cost in USD (Telnyx, SES, etc.).
     */
    #[Optional(nullable: true)]
    public ?float $costProvider;

    /**
     * Total cost in USD (MAU + provider cost).
     */
    #[Optional(nullable: true)]
    public ?float $costTotal;

    #[Optional(nullable: true)]
    public ?string $errorCode;

    #[Optional(nullable: true)]
    public ?string $errorMessage;

    #[Optional]
    public ?string $from;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Message ID from the delivery provider.
     */
    #[Optional('providerMessageId')]
    public ?string $providerMessageID;

    #[Optional('senderId')]
    public ?string $senderID;

    /**
     * Text content or caption.
     */
    #[Optional]
    public ?string $text;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new Message()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Message::with(
     *   id: ..., channel: ..., createdAt: ..., messageType: ..., status: ..., to: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Message)
     *   ->withID(...)
     *   ->withChannel(...)
     *   ->withCreatedAt(...)
     *   ->withMessageType(...)
     *   ->withStatus(...)
     *   ->withTo(...)
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
     * @param Channel|value-of<Channel> $channel
     * @param MessageType|value-of<MessageType> $messageType
     * @param MessageStatus|value-of<MessageStatus> $status
     * @param MessageContent|MessageContentShape|null $content
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $id,
        Channel|string $channel,
        \DateTimeInterface $createdAt,
        MessageType|string $messageType,
        MessageStatus|string $status,
        string $to,
        MessageContent|array|null $content = null,
        ?float $cost = null,
        ?float $costProvider = null,
        ?float $costTotal = null,
        ?string $errorCode = null,
        ?string $errorMessage = null,
        ?string $from = null,
        ?array $metadata = null,
        ?string $providerMessageID = null,
        ?string $senderID = null,
        ?string $text = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['channel'] = $channel;
        $self['createdAt'] = $createdAt;
        $self['messageType'] = $messageType;
        $self['status'] = $status;
        $self['to'] = $to;

        null !== $content && $self['content'] = $content;
        null !== $cost && $self['cost'] = $cost;
        null !== $costProvider && $self['costProvider'] = $costProvider;
        null !== $costTotal && $self['costTotal'] = $costTotal;
        null !== $errorCode && $self['errorCode'] = $errorCode;
        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $from && $self['from'] = $from;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $providerMessageID && $self['providerMessageID'] = $providerMessageID;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $text && $self['text'] = $text;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Delivery channel. Use 'auto' for intelligent routing.
     *
     * @param Channel|value-of<Channel> $channel
     */
    public function withChannel(Channel|string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Type of message. Non-text types are supported by WhatsApp and Telegram (varies by type).
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
     * @param MessageStatus|value-of<MessageStatus> $status
     */
    public function withStatus(MessageStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTo(string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Content for non-text message types (WhatsApp and Telegram).
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
     * MAU cost in USD (charged for first contact of the month).
     */
    public function withCost(?float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    /**
     * Provider cost in USD (Telnyx, SES, etc.).
     */
    public function withCostProvider(?float $costProvider): self
    {
        $self = clone $this;
        $self['costProvider'] = $costProvider;

        return $self;
    }

    /**
     * Total cost in USD (MAU + provider cost).
     */
    public function withCostTotal(?float $costTotal): self
    {
        $self = clone $this;
        $self['costTotal'] = $costTotal;

        return $self;
    }

    public function withErrorCode(?string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    public function withFrom(string $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Message ID from the delivery provider.
     */
    public function withProviderMessageID(string $providerMessageID): self
    {
        $self = clone $this;
        $self['providerMessageID'] = $providerMessageID;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Text content or caption.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
