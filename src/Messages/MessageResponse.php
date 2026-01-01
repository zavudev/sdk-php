<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type MessageShape from \Zavudev\Messages\Message
 *
 * @phpstan-type MessageResponseShape = array{message: Message|MessageShape}
 */
final class MessageResponse implements BaseModel
{
    /** @use SdkModel<MessageResponseShape> */
    use SdkModel;

    #[Required]
    public Message $message;

    /**
     * `new MessageResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageResponse::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageResponse)->withMessage(...)
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
     * @param Message|MessageShape $message
     */
    public static function with(Message|array $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * @param Message|MessageShape $message
     */
    public function withMessage(Message|array $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
