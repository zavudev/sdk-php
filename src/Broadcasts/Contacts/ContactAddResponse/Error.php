<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts\ContactAddResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ErrorShape = array{reason?: string|null, recipient?: string|null}
 */
final class Error implements BaseModel
{
    /** @use SdkModel<ErrorShape> */
    use SdkModel;

    #[Optional]
    public ?string $reason;

    #[Optional]
    public ?string $recipient;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $reason = null,
        ?string $recipient = null
    ): self {
        $self = new self;

        null !== $reason && $self['reason'] = $reason;
        null !== $recipient && $self['recipient'] = $recipient;

        return $self;
    }

    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    public function withRecipient(string $recipient): self
    {
        $self = clone $this;
        $self['recipient'] = $recipient;

        return $self;
    }
}
