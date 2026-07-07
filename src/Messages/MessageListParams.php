<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\MessageListParams\Channel;
use Zavudev\Messages\MessageListParams\Status;

/**
 * List messages previously sent by this project.
 *
 * @see Zavudev\Services\MessagesService::list()
 *
 * @phpstan-type MessageListParamsShape = array{
 *   channel?: null|\Zavudev\Messages\MessageListParams\Channel|value-of<\Zavudev\Messages\MessageListParams\Channel>,
 *   cursor?: string|null,
 *   limit?: int|null,
 *   status?: null|Status|value-of<Status>,
 *   to?: string|null,
 * }
 */
final class MessageListParams implements BaseModel
{
    /** @use SdkModel<MessageListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filter by delivery channel.
     *
     * @var value-of<Channel>|null $channel
     */
    #[Optional(enum: Channel::class)]
    public ?string $channel;

    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Filter by status. Not all stored statuses are filterable.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class)]
    public ?string $status;

    #[Optional]
    public ?string $to;

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
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        Channel|string|null $channel = null,
        ?string $cursor = null,
        ?int $limit = null,
        Status|string|null $status = null,
        ?string $to = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;
        null !== $to && $self['to'] = $to;

        return $self;
    }

    /**
     * Filter by delivery channel.
     *
     * @param Channel|value-of<Channel> $channel
     */
    public function withChannel(
        Channel|string $channel
    ): self {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Filter by status. Not all stored statuses are filterable.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
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
}
