<?php

declare(strict_types=1);

namespace Zavudev\Senders\Sender\Whatsapp;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Payment configuration status from Meta.
 *
 * @phpstan-type PaymentStatusShape = array{
 *   canSendTemplates?: bool|null,
 *   methodStatus?: string|null,
 *   setupStatus?: string|null,
 * }
 */
final class PaymentStatus implements BaseModel
{
    /** @use SdkModel<PaymentStatusShape> */
    use SdkModel;

    /**
     * Whether template messages can be sent. Requires setupStatus=COMPLETE and methodStatus=VALID.
     */
    #[Optional]
    public ?bool $canSendTemplates;

    /**
     * Payment method status (VALID, NONE, etc.).
     */
    #[Optional]
    public ?string $methodStatus;

    /**
     * Payment setup status (COMPLETE, NOT_STARTED, etc.).
     */
    #[Optional]
    public ?string $setupStatus;

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
        ?bool $canSendTemplates = null,
        ?string $methodStatus = null,
        ?string $setupStatus = null,
    ): self {
        $self = new self;

        null !== $canSendTemplates && $self['canSendTemplates'] = $canSendTemplates;
        null !== $methodStatus && $self['methodStatus'] = $methodStatus;
        null !== $setupStatus && $self['setupStatus'] = $setupStatus;

        return $self;
    }

    /**
     * Whether template messages can be sent. Requires setupStatus=COMPLETE and methodStatus=VALID.
     */
    public function withCanSendTemplates(bool $canSendTemplates): self
    {
        $self = clone $this;
        $self['canSendTemplates'] = $canSendTemplates;

        return $self;
    }

    /**
     * Payment method status (VALID, NONE, etc.).
     */
    public function withMethodStatus(string $methodStatus): self
    {
        $self = clone $this;
        $self['methodStatus'] = $methodStatus;

        return $self;
    }

    /**
     * Payment setup status (COMPLETE, NOT_STARTED, etc.).
     */
    public function withSetupStatus(string $setupStatus): self
    {
        $self = clone $this;
        $self['setupStatus'] = $setupStatus;

        return $self;
    }
}
