<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Broadcasts\Broadcast\ReviewResult;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BroadcastContentShape from \Zavudev\Broadcasts\BroadcastContent
 * @phpstan-import-type ReviewResultShape from \Zavudev\Broadcasts\Broadcast\ReviewResult
 *
 * @phpstan-type BroadcastShape = array{
 *   id: string,
 *   channel: BroadcastChannel|value-of<BroadcastChannel>,
 *   createdAt: \DateTimeInterface,
 *   messageType: BroadcastMessageType|value-of<BroadcastMessageType>,
 *   name: string,
 *   status: BroadcastStatus|value-of<BroadcastStatus>,
 *   totalContacts: int,
 *   actualCost?: float|null,
 *   completedAt?: \DateTimeInterface|null,
 *   content?: null|BroadcastContent|BroadcastContentShape,
 *   deliveredCount?: int|null,
 *   emailSubject?: string|null,
 *   estimatedCost?: float|null,
 *   failedCount?: int|null,
 *   metadata?: array<string,string>|null,
 *   pendingCount?: int|null,
 *   reservedAmount?: float|null,
 *   reviewAttempts?: int|null,
 *   reviewResult?: null|ReviewResult|ReviewResultShape,
 *   scheduledAt?: \DateTimeInterface|null,
 *   senderID?: string|null,
 *   sendingCount?: int|null,
 *   startedAt?: \DateTimeInterface|null,
 *   text?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Broadcast implements BaseModel
{
    /** @use SdkModel<BroadcastShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Broadcast delivery channel. Use 'smart' for per-contact intelligent routing.
     *
     * @var value-of<BroadcastChannel> $channel
     */
    #[Required(enum: BroadcastChannel::class)]
    public string $channel;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Type of message for broadcast.
     *
     * @var value-of<BroadcastMessageType> $messageType
     */
    #[Required(enum: BroadcastMessageType::class)]
    public string $messageType;

    #[Required]
    public string $name;

    /**
     * Current status of the broadcast.
     *
     * @var value-of<BroadcastStatus> $status
     */
    #[Required(enum: BroadcastStatus::class)]
    public string $status;

    /**
     * Total number of contacts in the broadcast.
     */
    #[Required]
    public int $totalContacts;

    /**
     * Actual cost so far in USD.
     */
    #[Optional(nullable: true)]
    public ?float $actualCost;

    #[Optional]
    public ?\DateTimeInterface $completedAt;

    /**
     * Content for non-text broadcast message types.
     */
    #[Optional]
    public ?BroadcastContent $content;

    #[Optional]
    public ?int $deliveredCount;

    #[Optional]
    public ?string $emailSubject;

    /**
     * Estimated total cost in USD.
     */
    #[Optional(nullable: true)]
    public ?float $estimatedCost;

    #[Optional]
    public ?int $failedCount;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    #[Optional]
    public ?int $pendingCount;

    /**
     * Amount reserved from balance in USD.
     */
    #[Optional(nullable: true)]
    public ?float $reservedAmount;

    /**
     * Number of review attempts (max 3).
     */
    #[Optional(nullable: true)]
    public ?int $reviewAttempts;

    /**
     * AI content review result.
     */
    #[Optional(nullable: true)]
    public ?ReviewResult $reviewResult;

    #[Optional]
    public ?\DateTimeInterface $scheduledAt;

    #[Optional('senderId')]
    public ?string $senderID;

    #[Optional]
    public ?int $sendingCount;

    #[Optional]
    public ?\DateTimeInterface $startedAt;

    #[Optional]
    public ?string $text;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new Broadcast()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Broadcast::with(
     *   id: ...,
     *   channel: ...,
     *   createdAt: ...,
     *   messageType: ...,
     *   name: ...,
     *   status: ...,
     *   totalContacts: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Broadcast)
     *   ->withID(...)
     *   ->withChannel(...)
     *   ->withCreatedAt(...)
     *   ->withMessageType(...)
     *   ->withName(...)
     *   ->withStatus(...)
     *   ->withTotalContacts(...)
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
     * @param BroadcastMessageType|value-of<BroadcastMessageType> $messageType
     * @param BroadcastStatus|value-of<BroadcastStatus> $status
     * @param BroadcastContent|BroadcastContentShape|null $content
     * @param array<string,string>|null $metadata
     * @param ReviewResult|ReviewResultShape|null $reviewResult
     */
    public static function with(
        string $id,
        BroadcastChannel|string $channel,
        \DateTimeInterface $createdAt,
        BroadcastMessageType|string $messageType,
        string $name,
        BroadcastStatus|string $status,
        int $totalContacts,
        ?float $actualCost = null,
        ?\DateTimeInterface $completedAt = null,
        BroadcastContent|array|null $content = null,
        ?int $deliveredCount = null,
        ?string $emailSubject = null,
        ?float $estimatedCost = null,
        ?int $failedCount = null,
        ?array $metadata = null,
        ?int $pendingCount = null,
        ?float $reservedAmount = null,
        ?int $reviewAttempts = null,
        ReviewResult|array|null $reviewResult = null,
        ?\DateTimeInterface $scheduledAt = null,
        ?string $senderID = null,
        ?int $sendingCount = null,
        ?\DateTimeInterface $startedAt = null,
        ?string $text = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['channel'] = $channel;
        $self['createdAt'] = $createdAt;
        $self['messageType'] = $messageType;
        $self['name'] = $name;
        $self['status'] = $status;
        $self['totalContacts'] = $totalContacts;

        null !== $actualCost && $self['actualCost'] = $actualCost;
        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $content && $self['content'] = $content;
        null !== $deliveredCount && $self['deliveredCount'] = $deliveredCount;
        null !== $emailSubject && $self['emailSubject'] = $emailSubject;
        null !== $estimatedCost && $self['estimatedCost'] = $estimatedCost;
        null !== $failedCount && $self['failedCount'] = $failedCount;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $pendingCount && $self['pendingCount'] = $pendingCount;
        null !== $reservedAmount && $self['reservedAmount'] = $reservedAmount;
        null !== $reviewAttempts && $self['reviewAttempts'] = $reviewAttempts;
        null !== $reviewResult && $self['reviewResult'] = $reviewResult;
        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $sendingCount && $self['sendingCount'] = $sendingCount;
        null !== $startedAt && $self['startedAt'] = $startedAt;
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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Current status of the broadcast.
     *
     * @param BroadcastStatus|value-of<BroadcastStatus> $status
     */
    public function withStatus(BroadcastStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Total number of contacts in the broadcast.
     */
    public function withTotalContacts(int $totalContacts): self
    {
        $self = clone $this;
        $self['totalContacts'] = $totalContacts;

        return $self;
    }

    /**
     * Actual cost so far in USD.
     */
    public function withActualCost(?float $actualCost): self
    {
        $self = clone $this;
        $self['actualCost'] = $actualCost;

        return $self;
    }

    public function withCompletedAt(\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

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

    public function withDeliveredCount(int $deliveredCount): self
    {
        $self = clone $this;
        $self['deliveredCount'] = $deliveredCount;

        return $self;
    }

    public function withEmailSubject(string $emailSubject): self
    {
        $self = clone $this;
        $self['emailSubject'] = $emailSubject;

        return $self;
    }

    /**
     * Estimated total cost in USD.
     */
    public function withEstimatedCost(?float $estimatedCost): self
    {
        $self = clone $this;
        $self['estimatedCost'] = $estimatedCost;

        return $self;
    }

    public function withFailedCount(int $failedCount): self
    {
        $self = clone $this;
        $self['failedCount'] = $failedCount;

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

    public function withPendingCount(int $pendingCount): self
    {
        $self = clone $this;
        $self['pendingCount'] = $pendingCount;

        return $self;
    }

    /**
     * Amount reserved from balance in USD.
     */
    public function withReservedAmount(?float $reservedAmount): self
    {
        $self = clone $this;
        $self['reservedAmount'] = $reservedAmount;

        return $self;
    }

    /**
     * Number of review attempts (max 3).
     */
    public function withReviewAttempts(?int $reviewAttempts): self
    {
        $self = clone $this;
        $self['reviewAttempts'] = $reviewAttempts;

        return $self;
    }

    /**
     * AI content review result.
     *
     * @param ReviewResult|ReviewResultShape|null $reviewResult
     */
    public function withReviewResult(
        ReviewResult|array|null $reviewResult
    ): self {
        $self = clone $this;
        $self['reviewResult'] = $reviewResult;

        return $self;
    }

    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withSendingCount(int $sendingCount): self
    {
        $self = clone $this;
        $self['sendingCount'] = $sendingCount;

        return $self;
    }

    public function withStartedAt(\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }

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
