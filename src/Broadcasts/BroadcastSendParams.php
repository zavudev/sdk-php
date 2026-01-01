<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Start sending the broadcast immediately or schedule for later. Reserves the estimated cost from your balance.
 *
 * @see Zavudev\Services\BroadcastsService::send()
 *
 * @phpstan-type BroadcastSendParamsShape = array{
 *   scheduledAt?: \DateTimeInterface|null
 * }
 */
final class BroadcastSendParams implements BaseModel
{
    /** @use SdkModel<BroadcastSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Schedule for future delivery. Omit to send immediately.
     */
    #[Optional]
    public ?\DateTimeInterface $scheduledAt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?\DateTimeInterface $scheduledAt = null): self
    {
        $self = new self;

        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * Schedule for future delivery. Omit to send immediately.
     */
    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }
}
