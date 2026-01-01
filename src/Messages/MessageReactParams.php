<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Send an emoji reaction to an existing WhatsApp message. Reactions are only supported for WhatsApp messages.
 *
 * @see Zavudev\Services\MessagesService::react()
 *
 * @phpstan-type MessageReactParamsShape = array{
 *   emoji: string, zavuSender?: string|null
 * }
 */
final class MessageReactParams implements BaseModel
{
    /** @use SdkModel<MessageReactParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Single emoji character to react with.
     */
    #[Required]
    public string $emoji;

    #[Optional]
    public ?string $zavuSender;

    /**
     * `new MessageReactParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageReactParams::with(emoji: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageReactParams)->withEmoji(...)
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
     */
    public static function with(string $emoji, ?string $zavuSender = null): self
    {
        $self = new self;

        $self['emoji'] = $emoji;

        null !== $zavuSender && $self['zavuSender'] = $zavuSender;

        return $self;
    }

    /**
     * Single emoji character to react with.
     */
    public function withEmoji(string $emoji): self
    {
        $self = clone $this;
        $self['emoji'] = $emoji;

        return $self;
    }

    public function withZavuSender(string $zavuSender): self
    {
        $self = clone $this;
        $self['zavuSender'] = $zavuSender;

        return $self;
    }
}
