<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type OwnedPhoneNumberPricingShape = array{
 *   isFreeNumber?: bool|null,
 *   monthlyCost?: float|null,
 *   monthlyPrice?: float|null,
 *   upfrontCost?: float|null,
 * }
 */
final class OwnedPhoneNumberPricing implements BaseModel
{
    /** @use SdkModel<OwnedPhoneNumberPricingShape> */
    use SdkModel;

    /**
     * Whether this is a free number.
     */
    #[Optional]
    public ?bool $isFreeNumber;

    /**
     * Monthly cost in cents.
     */
    #[Optional]
    public ?float $monthlyCost;

    /**
     * Monthly price in USD.
     */
    #[Optional]
    public ?float $monthlyPrice;

    /**
     * One-time purchase cost in cents.
     */
    #[Optional]
    public ?float $upfrontCost;

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
        ?bool $isFreeNumber = null,
        ?float $monthlyCost = null,
        ?float $monthlyPrice = null,
        ?float $upfrontCost = null,
    ): self {
        $self = new self;

        null !== $isFreeNumber && $self['isFreeNumber'] = $isFreeNumber;
        null !== $monthlyCost && $self['monthlyCost'] = $monthlyCost;
        null !== $monthlyPrice && $self['monthlyPrice'] = $monthlyPrice;
        null !== $upfrontCost && $self['upfrontCost'] = $upfrontCost;

        return $self;
    }

    /**
     * Whether this is a free number.
     */
    public function withIsFreeNumber(bool $isFreeNumber): self
    {
        $self = clone $this;
        $self['isFreeNumber'] = $isFreeNumber;

        return $self;
    }

    /**
     * Monthly cost in cents.
     */
    public function withMonthlyCost(float $monthlyCost): self
    {
        $self = clone $this;
        $self['monthlyCost'] = $monthlyCost;

        return $self;
    }

    /**
     * Monthly price in USD.
     */
    public function withMonthlyPrice(float $monthlyPrice): self
    {
        $self = clone $this;
        $self['monthlyPrice'] = $monthlyPrice;

        return $self;
    }

    /**
     * One-time purchase cost in cents.
     */
    public function withUpfrontCost(float $upfrontCost): self
    {
        $self = clone $this;
        $self['upfrontCost'] = $upfrontCost;

        return $self;
    }
}
