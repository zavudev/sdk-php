<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type AgentStatsShape = array{
 *   errorCount: int,
 *   successCount: int,
 *   totalCost: float,
 *   totalInvocations: int,
 *   totalTokensUsed: int,
 *   avgLatencyMs?: float|null,
 * }
 */
final class AgentStats implements BaseModel
{
    /** @use SdkModel<AgentStatsShape> */
    use SdkModel;

    #[Required]
    public int $errorCount;

    #[Required]
    public int $successCount;

    /**
     * Total cost in USD.
     */
    #[Required]
    public float $totalCost;

    #[Required]
    public int $totalInvocations;

    #[Required]
    public int $totalTokensUsed;

    #[Optional(nullable: true)]
    public ?float $avgLatencyMs;

    /**
     * `new AgentStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentStats::with(
     *   errorCount: ...,
     *   successCount: ...,
     *   totalCost: ...,
     *   totalInvocations: ...,
     *   totalTokensUsed: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentStats)
     *   ->withErrorCount(...)
     *   ->withSuccessCount(...)
     *   ->withTotalCost(...)
     *   ->withTotalInvocations(...)
     *   ->withTotalTokensUsed(...)
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
    public static function with(
        int $errorCount,
        int $successCount,
        float $totalCost,
        int $totalInvocations,
        int $totalTokensUsed,
        ?float $avgLatencyMs = null,
    ): self {
        $self = new self;

        $self['errorCount'] = $errorCount;
        $self['successCount'] = $successCount;
        $self['totalCost'] = $totalCost;
        $self['totalInvocations'] = $totalInvocations;
        $self['totalTokensUsed'] = $totalTokensUsed;

        null !== $avgLatencyMs && $self['avgLatencyMs'] = $avgLatencyMs;

        return $self;
    }

    public function withErrorCount(int $errorCount): self
    {
        $self = clone $this;
        $self['errorCount'] = $errorCount;

        return $self;
    }

    public function withSuccessCount(int $successCount): self
    {
        $self = clone $this;
        $self['successCount'] = $successCount;

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

    public function withAvgLatencyMs(?float $avgLatencyMs): self
    {
        $self = clone $this;
        $self['avgLatencyMs'] = $avgLatencyMs;

        return $self;
    }
}
