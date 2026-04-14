<?php

declare(strict_types=1);

namespace Zavudev\Plan;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Plan\PlanGetResponse\BillingInterval;
use Zavudev\Plan\PlanGetResponse\Limits;
use Zavudev\Plan\PlanGetResponse\Status;
use Zavudev\Plan\PlanGetResponse\Tier;

/**
 * @phpstan-import-type LimitsShape from \Zavudev\Plan\PlanGetResponse\Limits
 *
 * @phpstan-type PlanGetResponseShape = array{
 *   billingInterval: BillingInterval|value-of<BillingInterval>,
 *   status: Status|value-of<Status>,
 *   tier: Tier|value-of<Tier>,
 *   cancelAtPeriodEnd?: bool|null,
 *   currentPeriodEnd?: \DateTimeInterface|null,
 *   currentPeriodStart?: \DateTimeInterface|null,
 *   limits?: null|Limits|LimitsShape,
 * }
 */
final class PlanGetResponse implements BaseModel
{
    /** @use SdkModel<PlanGetResponseShape> */
    use SdkModel;

    /** @var value-of<BillingInterval> $billingInterval */
    #[Required(enum: BillingInterval::class)]
    public string $billingInterval;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Current subscription tier.
     *
     * @var value-of<Tier> $tier
     */
    #[Required(enum: Tier::class)]
    public string $tier;

    #[Optional]
    public ?bool $cancelAtPeriodEnd;

    #[Optional]
    public ?\DateTimeInterface $currentPeriodEnd;

    #[Optional]
    public ?\DateTimeInterface $currentPeriodStart;

    #[Optional]
    public ?Limits $limits;

    /**
     * `new PlanGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlanGetResponse::with(billingInterval: ..., status: ..., tier: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlanGetResponse)->withBillingInterval(...)->withStatus(...)->withTier(...)
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
     *
     * @param BillingInterval|value-of<BillingInterval> $billingInterval
     * @param Status|value-of<Status> $status
     * @param Tier|value-of<Tier> $tier
     * @param Limits|LimitsShape|null $limits
     */
    public static function with(
        BillingInterval|string $billingInterval,
        Status|string $status,
        Tier|string $tier,
        ?bool $cancelAtPeriodEnd = null,
        ?\DateTimeInterface $currentPeriodEnd = null,
        ?\DateTimeInterface $currentPeriodStart = null,
        Limits|array|null $limits = null,
    ): self {
        $self = new self;

        $self['billingInterval'] = $billingInterval;
        $self['status'] = $status;
        $self['tier'] = $tier;

        null !== $cancelAtPeriodEnd && $self['cancelAtPeriodEnd'] = $cancelAtPeriodEnd;
        null !== $currentPeriodEnd && $self['currentPeriodEnd'] = $currentPeriodEnd;
        null !== $currentPeriodStart && $self['currentPeriodStart'] = $currentPeriodStart;
        null !== $limits && $self['limits'] = $limits;

        return $self;
    }

    /**
     * @param BillingInterval|value-of<BillingInterval> $billingInterval
     */
    public function withBillingInterval(
        BillingInterval|string $billingInterval
    ): self {
        $self = clone $this;
        $self['billingInterval'] = $billingInterval;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Current subscription tier.
     *
     * @param Tier|value-of<Tier> $tier
     */
    public function withTier(Tier|string $tier): self
    {
        $self = clone $this;
        $self['tier'] = $tier;

        return $self;
    }

    public function withCancelAtPeriodEnd(bool $cancelAtPeriodEnd): self
    {
        $self = clone $this;
        $self['cancelAtPeriodEnd'] = $cancelAtPeriodEnd;

        return $self;
    }

    public function withCurrentPeriodEnd(
        \DateTimeInterface $currentPeriodEnd
    ): self {
        $self = clone $this;
        $self['currentPeriodEnd'] = $currentPeriodEnd;

        return $self;
    }

    public function withCurrentPeriodStart(
        \DateTimeInterface $currentPeriodStart
    ): self {
        $self = clone $this;
        $self['currentPeriodStart'] = $currentPeriodStart;

        return $self;
    }

    /**
     * @param Limits|LimitsShape $limits
     */
    public function withLimits(Limits|array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }
}
