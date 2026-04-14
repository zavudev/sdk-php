<?php

declare(strict_types=1);

namespace Zavudev\Plan\PlanGetResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type LimitsShape = array{
 *   broadcasts?: bool|null,
 *   emails?: int|null,
 *   messagesA2P?: int|null,
 *   phoneNumbers?: int|null,
 *   senders?: int|null,
 *   subAccounts?: bool|null,
 *   wabaConnections?: int|null,
 * }
 */
final class Limits implements BaseModel
{
    /** @use SdkModel<LimitsShape> */
    use SdkModel;

    #[Optional]
    public ?bool $broadcasts;

    /**
     * Monthly email limit.
     */
    #[Optional]
    public ?int $emails;

    /**
     * Monthly A2P message limit.
     */
    #[Optional]
    public ?int $messagesA2P;

    #[Optional]
    public ?int $phoneNumbers;

    #[Optional]
    public ?int $senders;

    #[Optional]
    public ?bool $subAccounts;

    #[Optional]
    public ?int $wabaConnections;

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
        ?bool $broadcasts = null,
        ?int $emails = null,
        ?int $messagesA2P = null,
        ?int $phoneNumbers = null,
        ?int $senders = null,
        ?bool $subAccounts = null,
        ?int $wabaConnections = null,
    ): self {
        $self = new self;

        null !== $broadcasts && $self['broadcasts'] = $broadcasts;
        null !== $emails && $self['emails'] = $emails;
        null !== $messagesA2P && $self['messagesA2P'] = $messagesA2P;
        null !== $phoneNumbers && $self['phoneNumbers'] = $phoneNumbers;
        null !== $senders && $self['senders'] = $senders;
        null !== $subAccounts && $self['subAccounts'] = $subAccounts;
        null !== $wabaConnections && $self['wabaConnections'] = $wabaConnections;

        return $self;
    }

    public function withBroadcasts(bool $broadcasts): self
    {
        $self = clone $this;
        $self['broadcasts'] = $broadcasts;

        return $self;
    }

    /**
     * Monthly email limit.
     */
    public function withEmails(int $emails): self
    {
        $self = clone $this;
        $self['emails'] = $emails;

        return $self;
    }

    /**
     * Monthly A2P message limit.
     */
    public function withMessagesA2P(int $messagesA2P): self
    {
        $self = clone $this;
        $self['messagesA2P'] = $messagesA2P;

        return $self;
    }

    public function withPhoneNumbers(int $phoneNumbers): self
    {
        $self = clone $this;
        $self['phoneNumbers'] = $phoneNumbers;

        return $self;
    }

    public function withSenders(int $senders): self
    {
        $self = clone $this;
        $self['senders'] = $senders;

        return $self;
    }

    public function withSubAccounts(bool $subAccounts): self
    {
        $self = clone $this;
        $self['subAccounts'] = $subAccounts;

        return $self;
    }

    public function withWabaConnections(int $wabaConnections): self
    {
        $self = clone $this;
        $self['wabaConnections'] = $wabaConnections;

        return $self;
    }
}
