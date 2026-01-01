<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Agent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type StatsShape = array{
 *   totalCost?: float|null,
 *   totalInvocations?: int|null,
 *   totalTokensUsed?: int|null,
 * }
 */
final class Stats implements BaseModel
{
    /** @use SdkModel<StatsShape> */
    use SdkModel;

    /**
     * Total cost in USD.
     */
    #[Optional]
    public ?float $totalCost;

    #[Optional]
    public ?int $totalInvocations;

    #[Optional]
    public ?int $totalTokensUsed;

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
        ?float $totalCost = null,
        ?int $totalInvocations = null,
        ?int $totalTokensUsed = null,
    ): self {
        $self = new self;

        null !== $totalCost && $self['totalCost'] = $totalCost;
        null !== $totalInvocations && $self['totalInvocations'] = $totalInvocations;
        null !== $totalTokensUsed && $self['totalTokensUsed'] = $totalTokensUsed;

        return $self;
    }

    /**
     * Total cost in USD.
     */
    public function withTotalCost(float $totalCost): self
    {
        $self = clone $this;
        $self['totalCost'] = $totalCost;

        return $self;
    }

    public function withTotalInvocations(int $totalInvocations): self
    {
        $self = clone $this;
        $self['totalInvocations'] = $totalInvocations;

        return $self;
    }

    public function withTotalTokensUsed(int $totalTokensUsed): self
    {
        $self = clone $this;
        $self['totalTokensUsed'] = $totalTokensUsed;

        return $self;
    }
}
