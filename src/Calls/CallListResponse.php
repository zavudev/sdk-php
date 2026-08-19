<?php

declare(strict_types=1);

namespace Zavudev\Calls;

use Zavudev\Calls\CallListResponse\Direction;
use Zavudev\Calls\CallListResponse\Status;
use Zavudev\Calls\CallListResponse\Transcript;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TranscriptShape from \Zavudev\Calls\CallListResponse\Transcript
 *
 * @phpstan-type CallListResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   direction: Direction|value-of<Direction>,
 *   from: string,
 *   status: Status|value-of<Status>,
 *   to: string,
 *   answeredAt?: \DateTimeInterface|null,
 *   cost?: float|null,
 *   durationSeconds?: int|null,
 *   endedAt?: \DateTimeInterface|null,
 *   endReason?: string|null,
 *   metadata?: array<string,string>|null,
 *   transcript?: list<Transcript|TranscriptShape>|null,
 *   turnCount?: int|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class CallListResponse implements BaseModel
{
    /** @use SdkModel<CallListResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Whether the call was placed by Zavu (outbound) or received from a caller (inbound).
     *
     * @var value-of<Direction> $direction
     */
    #[Required(enum: Direction::class)]
    public string $direction;

    /**
     * Caller phone number in E.164 format. Your sender's number for outbound calls; the caller's number for inbound calls.
     */
    #[Required]
    public string $from;

    /**
     * Lifecycle status of a voice call.
     * - `queued`: outbound call created, not yet dialing.
     * - `ringing`: dialing (outbound) or received and ringing (inbound).
     * - `in_progress`: answered, the agent is connected.
     * - `completed`: ended after a conversation.
     * - `failed`: could not be completed.
     * - `busy`: the line was busy.
     * - `no_answer`: rang but was not answered.
     * - `canceled`: canceled before it was answered.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Callee phone number in E.164 format.
     */
    #[Required]
    public string $to;

    /**
     * When the call was answered.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $answeredAt;

    /**
     * Total cost of the call in USD, combining the managed voice pipeline per-minute charge and telephony. Available once the call has ended.
     */
    #[Optional(nullable: true)]
    public ?float $cost;

    /**
     * Billable talk time in seconds, measured from answer to hangup.
     */
    #[Optional(nullable: true)]
    public ?int $durationSeconds;

    /**
     * When the call ended.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $endedAt;

    /**
     * Why the call ended (e.g. `agent_ended`, `max_duration`, `transfer`, `hangup`). Present once the call is no longer active.
     */
    #[Optional(nullable: true)]
    public ?string $endReason;

    /**
     * Arbitrary metadata you attached when creating the call.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Ordered transcript of the call. Included when retrieving a single call; omitted from list responses.
     *
     * @var list<Transcript>|null $transcript
     */
    #[Optional(list: Transcript::class)]
    public ?array $transcript;

    /**
     * Number of conversation turns exchanged during the call.
     */
    #[Optional(nullable: true)]
    public ?int $turnCount;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new CallListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CallListResponse::with(
     *   id: ..., createdAt: ..., direction: ..., from: ..., status: ..., to: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CallListResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDirection(...)
     *   ->withFrom(...)
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
     * @param Direction|value-of<Direction> $direction
     * @param Status|value-of<Status> $status
     * @param array<string,string>|null $metadata
     * @param list<Transcript|TranscriptShape>|null $transcript
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        Direction|string $direction,
        string $from,
        Status|string $status,
        string $to,
        ?\DateTimeInterface $answeredAt = null,
        ?float $cost = null,
        ?int $durationSeconds = null,
        ?\DateTimeInterface $endedAt = null,
        ?string $endReason = null,
        ?array $metadata = null,
        ?array $transcript = null,
        ?int $turnCount = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['direction'] = $direction;
        $self['from'] = $from;
        $self['status'] = $status;
        $self['to'] = $to;

        null !== $answeredAt && $self['answeredAt'] = $answeredAt;
        null !== $cost && $self['cost'] = $cost;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;
        null !== $endedAt && $self['endedAt'] = $endedAt;
        null !== $endReason && $self['endReason'] = $endReason;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $transcript && $self['transcript'] = $transcript;
        null !== $turnCount && $self['turnCount'] = $turnCount;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Whether the call was placed by Zavu (outbound) or received from a caller (inbound).
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
     * Caller phone number in E.164 format. Your sender's number for outbound calls; the caller's number for inbound calls.
     */
    public function withFrom(string $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Lifecycle status of a voice call.
     * - `queued`: outbound call created, not yet dialing.
     * - `ringing`: dialing (outbound) or received and ringing (inbound).
     * - `in_progress`: answered, the agent is connected.
     * - `completed`: ended after a conversation.
     * - `failed`: could not be completed.
     * - `busy`: the line was busy.
     * - `no_answer`: rang but was not answered.
     * - `canceled`: canceled before it was answered.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Callee phone number in E.164 format.
     */
    public function withTo(string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * When the call was answered.
     */
    public function withAnsweredAt(?\DateTimeInterface $answeredAt): self
    {
        $self = clone $this;
        $self['answeredAt'] = $answeredAt;

        return $self;
    }

    /**
     * Total cost of the call in USD, combining the managed voice pipeline per-minute charge and telephony. Available once the call has ended.
     */
    public function withCost(?float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    /**
     * Billable talk time in seconds, measured from answer to hangup.
     */
    public function withDurationSeconds(?int $durationSeconds): self
    {
        $self = clone $this;
        $self['durationSeconds'] = $durationSeconds;

        return $self;
    }

    /**
     * When the call ended.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $self = clone $this;
        $self['endedAt'] = $endedAt;

        return $self;
    }

    /**
     * Why the call ended (e.g. `agent_ended`, `max_duration`, `transfer`, `hangup`). Present once the call is no longer active.
     */
    public function withEndReason(?string $endReason): self
    {
        $self = clone $this;
        $self['endReason'] = $endReason;

        return $self;
    }

    /**
     * Arbitrary metadata you attached when creating the call.
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
     * Ordered transcript of the call. Included when retrieving a single call; omitted from list responses.
     *
     * @param list<Transcript|TranscriptShape> $transcript
     */
    public function withTranscript(array $transcript): self
    {
        $self = clone $this;
        $self['transcript'] = $transcript;

        return $self;
    }

    /**
     * Number of conversation turns exchanged during the call.
     */
    public function withTurnCount(?int $turnCount): self
    {
        $self = clone $this;
        $self['turnCount'] = $turnCount;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
