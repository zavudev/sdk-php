<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update the scheduled time for a broadcast. The broadcast must be in scheduled status.
 *
 * @see Zavudev\Services\BroadcastsService::reschedule()
 *
 * @phpstan-type BroadcastRescheduleParamsShape = array{
 *   scheduledAt: \DateTimeInterface
 * }
 */
final class BroadcastRescheduleParams implements BaseModel
{
    /** @use SdkModel<BroadcastRescheduleParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * New scheduled time for the broadcast.
     */
    #[Required]
    public \DateTimeInterface $scheduledAt;

    /**
     * `new BroadcastRescheduleParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BroadcastRescheduleParams::with(scheduledAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BroadcastRescheduleParams)->withScheduledAt(...)
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
    public static function with(\DateTimeInterface $scheduledAt): self
    {
        $self = new self;

        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * New scheduled time for the broadcast.
     */
    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }
}
