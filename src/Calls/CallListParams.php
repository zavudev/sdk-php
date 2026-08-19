<?php

declare(strict_types=1);

namespace Zavudev\Calls;

use Zavudev\Calls\CallListParams\Direction;
use Zavudev\Calls\CallListParams\Status;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List voice calls for this project, most recent first. Transcripts are omitted from the list; fetch a single call to get its transcript.
 *
 * @see Zavudev\Services\CallsService::list()
 *
 * @phpstan-type CallListParamsShape = array{
 *   cursor?: string|null,
 *   direction?: null|Direction|value-of<Direction>,
 *   limit?: int|null,
 *   status?: null|Status|value-of<Status>,
 * }
 */
final class CallListParams implements BaseModel
{
    /** @use SdkModel<CallListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $cursor;

    /**
     * Whether the call was placed by Zavu (outbound) or received from a caller (inbound).
     *
     * @var value-of<Direction>|null $direction
     */
    #[Optional(enum: Direction::class)]
    public ?string $direction;

    #[Optional]
    public ?int $limit;

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
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Direction|value-of<Direction>|null $direction
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $cursor = null,
        Direction|string|null $direction = null,
        ?int $limit = null,
        Status|string|null $status = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $direction && $self['direction'] = $direction;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

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

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
}
