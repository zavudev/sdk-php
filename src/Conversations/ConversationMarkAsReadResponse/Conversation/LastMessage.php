<?php

declare(strict_types=1);

namespace Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation;

use Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\LastMessage\Direction;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\Channel;

/**
 * Denormalized preview of the most recent message, so a thread list needs no extra fetch.
 *
 * @phpstan-type LastMessageShape = array{
 *   id: string,
 *   at: \DateTimeInterface,
 *   channel: Channel|value-of<Channel>,
 *   direction: Direction|value-of<Direction>,
 *   text: string,
 * }
 */
final class LastMessage implements BaseModel
{
    /** @use SdkModel<LastMessageShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $at;

    /**
     * Delivery channel. Use 'auto' for intelligent routing.
     *
     * @var value-of<Channel> $channel
     */
    #[Required(enum: Channel::class)]
    public string $channel;

    /** @var value-of<Direction> $direction */
    #[Required(enum: Direction::class)]
    public string $direction;

    /**
     * Text or caption. Empty when the last message carried no text (e.g. media).
     */
    #[Required]
    public string $text;

    /**
     * `new LastMessage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * LastMessage::with(id: ..., at: ..., channel: ..., direction: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new LastMessage)
     *   ->withID(...)
     *   ->withAt(...)
     *   ->withChannel(...)
     *   ->withDirection(...)
     *   ->withText(...)
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
     */
    public static function with(
        string $id,
        \DateTimeInterface $at,
        Channel|string $channel,
        Direction|string $direction,
        string $text,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['at'] = $at;
        $self['channel'] = $channel;
        $self['direction'] = $direction;
        $self['text'] = $text;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAt(\DateTimeInterface $at): self
    {
        $self = clone $this;
        $self['at'] = $at;

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

    /**
     * @param Direction|value-of<Direction> $direction
     */
    public function withDirection(Direction|string $direction): self
    {
        $self = clone $this;
        $self['direction'] = $direction;

        return $self;
    }

    /**
     * Text or caption. Empty when the last message carried no text (e.g. media).
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
