<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Mark an inbound WhatsApp message as read and display a typing indicator to the user while you prepare a response. The indicator is automatically dismissed when you send a reply, or after 25 seconds — whichever comes first. Only valid for inbound WhatsApp messages. Use this when a reply will take more than a couple of seconds (LLM agent, tool call, lookup) to improve the recipient's experience.
 *
 * @see Zavudev\Services\MessagesService::showTyping()
 *
 * @phpstan-type MessageShowTypingParamsShape = array{zavuSender?: string|null}
 */
final class MessageShowTypingParams implements BaseModel
{
    /** @use SdkModel<MessageShowTypingParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $zavuSender;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $zavuSender = null): self
    {
        $self = new self;

        null !== $zavuSender && $self['zavuSender'] = $zavuSender;

        return $self;
    }

    public function withZavuSender(string $zavuSender): self
    {
        $self = clone $this;
        $self['zavuSender'] = $zavuSender;

        return $self;
    }
}
