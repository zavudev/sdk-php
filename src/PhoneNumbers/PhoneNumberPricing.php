<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type PhoneNumberPricingShape = array{
 *   isFreeEligible?: bool|null,
 *   monthlyPrice?: float|null,
 *   upfrontPrice?: float|null,
 * }
 */
final class PhoneNumberPricing implements BaseModel
{
    /** @use SdkModel<PhoneNumberPricingShape> */
    use SdkModel;

    /**
     * Whether this number qualifies for the free first US number offer.
     */
    #[Optional]
    public ?bool $isFreeEligible;

    /**
     * Monthly price in USD.
     */
    #[Optional]
    public ?float $monthlyPrice;

    /**
     * One-time purchase price in USD.
     */
    #[Optional]
    public ?float $upfrontPrice;

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
        ?bool $isFreeEligible = null,
        ?float $monthlyPrice = null,
        ?float $upfrontPrice = null,
    ): self {
        $self = new self;

        null !== $isFreeEligible && $self['isFreeEligible'] = $isFreeEligible;
        null !== $monthlyPrice && $self['monthlyPrice'] = $monthlyPrice;
        null !== $upfrontPrice && $self['upfrontPrice'] = $upfrontPrice;

        return $self;
    }

    /**
     * Whether this number qualifies for the free first US number offer.
     */
    public function withIsFreeEligible(bool $isFreeEligible): self
    {
        $self = clone $this;
        $self['isFreeEligible'] = $isFreeEligible;

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
     * One-time purchase price in USD.
     */
    public function withUpfrontPrice(float $upfrontPrice): self
    {
        $self = clone $this;
        $self['upfrontPrice'] = $upfrontPrice;

        return $self;
    }
}
