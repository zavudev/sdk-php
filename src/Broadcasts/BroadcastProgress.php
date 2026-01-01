<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type BroadcastProgressShape = array{
 *   broadcastID: string,
 *   delivered: int,
 *   failed: int,
 *   pending: int,
 *   percentComplete: float,
 *   sending: int,
 *   skipped: int,
 *   status: BroadcastStatus|value-of<BroadcastStatus>,
 *   total: int,
 *   actualCost?: float|null,
 *   estimatedCompletionAt?: \DateTimeInterface|null,
 *   estimatedCost?: float|null,
 *   reservedAmount?: float|null,
 *   startedAt?: \DateTimeInterface|null,
 * }
 */
final class BroadcastProgress implements BaseModel
{
    /** @use SdkModel<BroadcastProgressShape> */
    use SdkModel;

    #[Required('broadcastId')]
    public string $broadcastID;

    /**
     * Successfully delivered.
     */
    #[Required]
    public int $delivered;

    /**
     * Failed to deliver.
     */
    #[Required]
    public int $failed;

    /**
     * Not yet queued for sending.
     */
    #[Required]
    public int $pending;

    /**
     * Percentage complete (0-100).
     */
    #[Required]
    public float $percentComplete;

    /**
     * Currently being sent.
     */
    #[Required]
    public int $sending;

    /**
     * Skipped (broadcast cancelled).
     */
    #[Required]
    public int $skipped;

    /**
     * Current status of the broadcast.
     *
     * @var value-of<BroadcastStatus> $status
     */
    #[Required(enum: BroadcastStatus::class)]
    public string $status;

    /**
     * Total contacts in broadcast.
     */
    #[Required]
    public int $total;

    /**
     * Actual cost so far in USD.
     */
    #[Optional(nullable: true)]
    public ?float $actualCost;

    #[Optional]
    public ?\DateTimeInterface $estimatedCompletionAt;

    /**
     * Estimated total cost in USD.
     */
    #[Optional(nullable: true)]
    public ?float $estimatedCost;

    /**
     * Amount reserved from balance in USD.
     */
    #[Optional(nullable: true)]
    public ?float $reservedAmount;

    #[Optional]
    public ?\DateTimeInterface $startedAt;

    /**
     * `new BroadcastProgress()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BroadcastProgress::with(
     *   broadcastID: ...,
     *   delivered: ...,
     *   failed: ...,
     *   pending: ...,
     *   percentComplete: ...,
     *   sending: ...,
     *   skipped: ...,
     *   status: ...,
     *   total: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BroadcastProgress)
     *   ->withBroadcastID(...)
     *   ->withDelivered(...)
     *   ->withFailed(...)
     *   ->withPending(...)
     *   ->withPercentComplete(...)
     *   ->withSending(...)
     *   ->withSkipped(...)
     *   ->withStatus(...)
     *   ->withTotal(...)
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
     * @param BroadcastStatus|value-of<BroadcastStatus> $status
     */
    public static function with(
        string $broadcastID,
        int $delivered,
        int $failed,
        int $pending,
        float $percentComplete,
        int $sending,
        int $skipped,
        BroadcastStatus|string $status,
        int $total,
        ?float $actualCost = null,
        ?\DateTimeInterface $estimatedCompletionAt = null,
        ?float $estimatedCost = null,
        ?float $reservedAmount = null,
        ?\DateTimeInterface $startedAt = null,
    ): self {
        $self = new self;

        $self['broadcastID'] = $broadcastID;
        $self['delivered'] = $delivered;
        $self['failed'] = $failed;
        $self['pending'] = $pending;
        $self['percentComplete'] = $percentComplete;
        $self['sending'] = $sending;
        $self['skipped'] = $skipped;
        $self['status'] = $status;
        $self['total'] = $total;

        null !== $actualCost && $self['actualCost'] = $actualCost;
        null !== $estimatedCompletionAt && $self['estimatedCompletionAt'] = $estimatedCompletionAt;
        null !== $estimatedCost && $self['estimatedCost'] = $estimatedCost;
        null !== $reservedAmount && $self['reservedAmount'] = $reservedAmount;
        null !== $startedAt && $self['startedAt'] = $startedAt;

        return $self;
    }

    public function withBroadcastID(string $broadcastID): self
    {
        $self = clone $this;
        $self['broadcastID'] = $broadcastID;

        return $self;
    }

    /**
     * Successfully delivered.
     */
    public function withDelivered(int $delivered): self
    {
        $self = clone $this;
        $self['delivered'] = $delivered;

        return $self;
    }

    /**
     * Failed to deliver.
     */
    public function withFailed(int $failed): self
    {
        $self = clone $this;
        $self['failed'] = $failed;

        return $self;
    }

    /**
     * Not yet queued for sending.
     */
    public function withPending(int $pending): self
    {
        $self = clone $this;
        $self['pending'] = $pending;

        return $self;
    }

    /**
     * Percentage complete (0-100).
     */
    public function withPercentComplete(float $percentComplete): self
    {
        $self = clone $this;
        $self['percentComplete'] = $percentComplete;

        return $self;
    }

    /**
     * Currently being sent.
     */
    public function withSending(int $sending): self
    {
        $self = clone $this;
        $self['sending'] = $sending;

        return $self;
    }

    /**
     * Skipped (broadcast cancelled).
     */
    public function withSkipped(int $skipped): self
    {
        $self = clone $this;
        $self['skipped'] = $skipped;

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
     * Total contacts in broadcast.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

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

    public function withEstimatedCompletionAt(
        \DateTimeInterface $estimatedCompletionAt
    ): self {
        $self = clone $this;
        $self['estimatedCompletionAt'] = $estimatedCompletionAt;

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

    /**
     * Amount reserved from balance in USD.
     */
    public function withReservedAmount(?float $reservedAmount): self
    {
        $self = clone $this;
        $self['reservedAmount'] = $reservedAmount;

        return $self;
    }

    public function withStartedAt(\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }
}
