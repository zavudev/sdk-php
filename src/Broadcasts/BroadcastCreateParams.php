<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a new broadcast campaign. Add contacts after creation, then send.
 *
 * @see Zavudev\Services\BroadcastsService::create()
 *
 * @phpstan-import-type BroadcastContentShape from \Zavudev\Broadcasts\BroadcastContent
 *
 * @phpstan-type BroadcastCreateParamsShape = array{
 *   channel: BroadcastChannel|value-of<BroadcastChannel>,
 *   name: string,
 *   content?: null|BroadcastContent|BroadcastContentShape,
 *   emailHTMLBody?: string|null,
 *   emailSubject?: string|null,
 *   idempotencyKey?: string|null,
 *   messageType?: null|BroadcastMessageType|value-of<BroadcastMessageType>,
 *   metadata?: array<string,string>|null,
 *   scheduledAt?: \DateTimeInterface|null,
 *   senderID?: string|null,
 *   text?: string|null,
 * }
 */
final class BroadcastCreateParams implements BaseModel
{
    /** @use SdkModel<BroadcastCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Broadcast delivery channel. Use 'smart' for per-contact intelligent routing.
     *
     * @var value-of<BroadcastChannel> $channel
     */
    #[Required(enum: BroadcastChannel::class)]
    public string $channel;

    /**
     * Name of the broadcast campaign.
     */
    #[Required]
    public string $name;

    /**
     * Content for non-text broadcast message types.
     */
    #[Optional]
    public ?BroadcastContent $content;

    /**
     * HTML body for email broadcasts.
     */
    #[Optional('emailHtmlBody')]
    public ?string $emailHTMLBody;

    /**
     * Email subject line. Required for email broadcasts.
     */
    #[Optional]
    public ?string $emailSubject;

    /**
     * Idempotency key to prevent duplicate broadcasts.
     */
    #[Optional]
    public ?string $idempotencyKey;

    /**
     * Type of message for broadcast.
     *
     * @var value-of<BroadcastMessageType>|null $messageType
     */
    #[Optional(enum: BroadcastMessageType::class)]
    public ?string $messageType;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Schedule the broadcast for future delivery.
     */
    #[Optional]
    public ?\DateTimeInterface $scheduledAt;

    /**
     * Sender profile ID. Uses default sender if omitted.
     */
    #[Optional('senderId')]
    public ?string $senderID;

    /**
     * Text content or caption. Supports template variables: {{name}}, {{1}}, etc.
     */
    #[Optional]
    public ?string $text;

    /**
     * `new BroadcastCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BroadcastCreateParams::with(channel: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BroadcastCreateParams)->withChannel(...)->withName(...)
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
     * @param BroadcastChannel|value-of<BroadcastChannel> $channel
     * @param BroadcastContent|BroadcastContentShape|null $content
     * @param BroadcastMessageType|value-of<BroadcastMessageType>|null $messageType
     * @param array<string,string>|null $metadata
     */
    public static function with(
        BroadcastChannel|string $channel,
        string $name,
        BroadcastContent|array|null $content = null,
        ?string $emailHTMLBody = null,
        ?string $emailSubject = null,
        ?string $idempotencyKey = null,
        BroadcastMessageType|string|null $messageType = null,
        ?array $metadata = null,
        ?\DateTimeInterface $scheduledAt = null,
        ?string $senderID = null,
        ?string $text = null,
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['name'] = $name;

        null !== $content && $self['content'] = $content;
        null !== $emailHTMLBody && $self['emailHTMLBody'] = $emailHTMLBody;
        null !== $emailSubject && $self['emailSubject'] = $emailSubject;
        null !== $idempotencyKey && $self['idempotencyKey'] = $idempotencyKey;
        null !== $messageType && $self['messageType'] = $messageType;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * Broadcast delivery channel. Use 'smart' for per-contact intelligent routing.
     *
     * @param BroadcastChannel|value-of<BroadcastChannel> $channel
     */
    public function withChannel(BroadcastChannel|string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Name of the broadcast campaign.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Content for non-text broadcast message types.
     *
     * @param BroadcastContent|BroadcastContentShape $content
     */
    public function withContent(BroadcastContent|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * HTML body for email broadcasts.
     */
    public function withEmailHTMLBody(string $emailHTMLBody): self
    {
        $self = clone $this;
        $self['emailHTMLBody'] = $emailHTMLBody;

        return $self;
    }

    /**
     * Email subject line. Required for email broadcasts.
     */
    public function withEmailSubject(string $emailSubject): self
    {
        $self = clone $this;
        $self['emailSubject'] = $emailSubject;

        return $self;
    }

    /**
     * Idempotency key to prevent duplicate broadcasts.
     */
    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Type of message for broadcast.
     *
     * @param BroadcastMessageType|value-of<BroadcastMessageType> $messageType
     */
    public function withMessageType(
        BroadcastMessageType|string $messageType
    ): self {
        $self = clone $this;
        $self['messageType'] = $messageType;

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
     * Schedule the broadcast for future delivery.
     */
    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * Sender profile ID. Uses default sender if omitted.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Text content or caption. Supports template variables: {{name}}, {{1}}, etc.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
