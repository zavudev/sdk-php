<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageShowTypingResponseShape = array{success: bool}
 */
final class MessageShowTypingResponse implements BaseModel
{
    /** @use SdkModel<MessageShowTypingResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success;

    /**
     * `new MessageShowTypingResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageShowTypingResponse::with(success: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageShowTypingResponse)->withSuccess(...)
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
    public static function with(bool $success): self
    {
        $self = new self;

        $self['success'] = $success;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
