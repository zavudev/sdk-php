<?php

declare(strict_types=1);

namespace Zavudev\Usage\UsageGetResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type LimitsShape = array{emails?: int|null, messagesA2P?: int|null}
 */
final class Limits implements BaseModel
{
    /** @use SdkModel<LimitsShape> */
    use SdkModel;

    #[Optional]
    public ?int $emails;

    #[Optional]
    public ?int $messagesA2P;

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
        ?int $emails = null,
        ?int $messagesA2P = null
    ): self {
        $self = new self;

        null !== $emails && $self['emails'] = $emails;
        null !== $messagesA2P && $self['messagesA2P'] = $messagesA2P;

        return $self;
    }

    public function withEmails(int $emails): self
    {
        $self = clone $this;
        $self['emails'] = $emails;

        return $self;
    }

    public function withMessagesA2P(int $messagesA2P): self
    {
        $self = clone $this;
        $self['messagesA2P'] = $messagesA2P;

        return $self;
    }
}
