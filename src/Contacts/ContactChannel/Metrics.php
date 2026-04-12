<?php

declare(strict_types=1);

namespace Zavudev\Contacts\ContactChannel;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Delivery metrics for this channel.
 *
 * @phpstan-type MetricsShape = array{
 *   avgDeliveryTimeMs?: float|null,
 *   failureCount?: int|null,
 *   lastSuccessAt?: \DateTimeInterface|null,
 *   successCount?: int|null,
 *   totalAttempts?: int|null,
 * }
 */
final class Metrics implements BaseModel
{
    /** @use SdkModel<MetricsShape> */
    use SdkModel;

    #[Optional]
    public ?float $avgDeliveryTimeMs;

    #[Optional]
    public ?int $failureCount;

    #[Optional]
    public ?\DateTimeInterface $lastSuccessAt;

    #[Optional]
    public ?int $successCount;

    #[Optional]
    public ?int $totalAttempts;

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
        ?float $avgDeliveryTimeMs = null,
        ?int $failureCount = null,
        ?\DateTimeInterface $lastSuccessAt = null,
        ?int $successCount = null,
        ?int $totalAttempts = null,
    ): self {
        $self = new self;

        null !== $avgDeliveryTimeMs && $self['avgDeliveryTimeMs'] = $avgDeliveryTimeMs;
        null !== $failureCount && $self['failureCount'] = $failureCount;
        null !== $lastSuccessAt && $self['lastSuccessAt'] = $lastSuccessAt;
        null !== $successCount && $self['successCount'] = $successCount;
        null !== $totalAttempts && $self['totalAttempts'] = $totalAttempts;

        return $self;
    }

    public function withAvgDeliveryTimeMs(float $avgDeliveryTimeMs): self
    {
        $self = clone $this;
        $self['avgDeliveryTimeMs'] = $avgDeliveryTimeMs;

        return $self;
    }

    public function withFailureCount(int $failureCount): self
    {
        $self = clone $this;
        $self['failureCount'] = $failureCount;

        return $self;
    }

    public function withLastSuccessAt(\DateTimeInterface $lastSuccessAt): self
    {
        $self = clone $this;
        $self['lastSuccessAt'] = $lastSuccessAt;

        return $self;
    }

    public function withSuccessCount(int $successCount): self
    {
        $self = clone $this;
        $self['successCount'] = $successCount;

        return $self;
    }

    public function withTotalAttempts(int $totalAttempts): self
    {
        $self = clone $this;
        $self['totalAttempts'] = $totalAttempts;

        return $self;
    }
}
