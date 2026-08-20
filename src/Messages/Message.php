<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\Message\Direction;

/**
 * @phpstan-import-type MessageContentShape from \Zavudev\Messages\MessageContent
 *
 * @phpstan-type MessageShape = array{
 *   id: string,
 *   channel: Channel|value-of<Channel>,
 *   createdAt: \DateTimeInterface,
 *   direction: Direction|value-of<Direction>,
 *   messageType: MessageType|value-of<MessageType>,
 *   status: MessageStatus|value-of<MessageStatus>,
 *   to: string,
 *   content?: null|MessageContent|MessageContentShape,
 *   conversationID?: string|null,
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
     * Who sent the message. Needed to render a thread: `status` cannot tell the two apart, because an inbound message is also stored as `delivered`.
     *
     * @var value-of<Direction> $direction
     */
    #[Required(enum: Direction::class)]
    public string $direction;

    /**
     * Type of message. Non-text types are supported by WhatsApp and Telegram (varies by type).
     *
     * `location_request` asks the recipient to share their location and is WhatsApp-only. It takes no `content` object — the prompt goes in `text` (max 1024 characters) and the button label is fixed by WhatsApp. The recipient's answer arrives as an inbound `location` message whose `content.replyToMessageId` is the ID of the request.
     *
     * `request_contact_info` asks the recipient to share their phone number and is WhatsApp-only. Like `location_request` it takes no `content` object — the prompt goes in `text` (max 1024 characters) and WhatsApp renders a fixed **Share Contact Info** button. The answer arrives as an inbound `contact` message. Use it to recover the phone number of a contact who adopted a WhatsApp username and is only known by their business-scoped user ID (BSUID); when they share it, Zavu automatically links the phone number to that contact.
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
     * ID of the conversation (inbox thread) this message belongs to. Use it to build a direct dashboard link: `https://dashboard.zavu.dev/{locale}/inbox?conv={conversationId}`. Omitted only on legacy messages created before conversation threading.
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    /**
     * Zavu platform charge in USD for this message. Messaging is billed against your plan's monthly limits plus usage-based overage.
     */
    #[Optional(nullable: true)]
    public ?float $cost;

    /**
     * Carrier and delivery cost in USD.
     */
    #[Optional(nullable: true)]
    public ?float $costProvider;

    /**
     * Total cost in USD (platform charge + delivery cost).
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
     *   id: ...,
     *   channel: ...,
     *   createdAt: ...,
     *   direction: ...,
     *   messageType: ...,
     *   status: ...,
     *   to: ...,
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
     *   ->withDirection(...)
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
     * @param Direction|value-of<Direction> $direction
     * @param MessageType|value-of<MessageType> $messageType
     * @param MessageStatus|value-of<MessageStatus> $status
     * @param MessageContent|MessageContentShape|null $content
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $id,
        Channel|string $channel,
        \DateTimeInterface $createdAt,
        Direction|string $direction,
        MessageType|string $messageType,
        MessageStatus|string $status,
        string $to,
        MessageContent|array|null $content = null,
        ?string $conversationID = null,
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
        $self['direction'] = $direction;
        $self['messageType'] = $messageType;
        $self['status'] = $status;
        $self['to'] = $to;

        null !== $content && $self['content'] = $content;
        null !== $conversationID && $self['conversationID'] = $conversationID;
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
     * Who sent the message. Needed to render a thread: `status` cannot tell the two apart, because an inbound message is also stored as `delivered`.
     *
     * @param Direction|value-of<Direction> $direction
     */
    public function withDirection(Direction|string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * Type of message. Non-text types are supported by WhatsApp and Telegram (varies by type).
     *
     * `location_request` asks the recipient to share their location and is WhatsApp-only. It takes no `content` object — the prompt goes in `text` (max 1024 characters) and the button label is fixed by WhatsApp. The recipient's answer arrives as an inbound `location` message whose `content.replyToMessageId` is the ID of the request.
     *
     * `request_contact_info` asks the recipient to share their phone number and is WhatsApp-only. Like `location_request` it takes no `content` object — the prompt goes in `text` (max 1024 characters) and WhatsApp renders a fixed **Share Contact Info** button. The answer arrives as an inbound `contact` message. Use it to recover the phone number of a contact who adopted a WhatsApp username and is only known by their business-scoped user ID (BSUID); when they share it, Zavu automatically links the phone number to that contact.
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
     * ID of the conversation (inbox thread) this message belongs to. Use it to build a direct dashboard link: `https://dashboard.zavu.dev/{locale}/inbox?conv={conversationId}`. Omitted only on legacy messages created before conversation threading.
     */
    public function withConversationID(string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    /**
     * Zavu platform charge in USD for this message. Messaging is billed against your plan's monthly limits plus usage-based overage.
     */
    public function withCost(?float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    /**
     * Carrier and delivery cost in USD.
     */
    public function withCostProvider(?float $costProvider): self
    {
        $self = clone $this;
        $self['costProvider'] = $costProvider;

        return $self;
    }

    /**
     * Total cost in USD (platform charge + delivery cost).
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
