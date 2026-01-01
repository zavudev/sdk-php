<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PhoneNumberCapabilitiesShape from \Zavudev\PhoneNumbers\PhoneNumberCapabilities
 * @phpstan-import-type PhoneNumberPricingShape from \Zavudev\PhoneNumbers\PhoneNumberPricing
 *
 * @phpstan-type AvailablePhoneNumberShape = array{
 *   capabilities: PhoneNumberCapabilities|PhoneNumberCapabilitiesShape,
 *   phoneNumber: string,
 *   pricing: PhoneNumberPricing|PhoneNumberPricingShape,
 *   friendlyName?: string|null,
 *   locality?: string|null,
 *   region?: string|null,
 * }
 */
final class AvailablePhoneNumber implements BaseModel
{
    /** @use SdkModel<AvailablePhoneNumberShape> */
    use SdkModel;

    #[Required]
    public PhoneNumberCapabilities $capabilities;

    #[Required]
    public string $phoneNumber;

    #[Required]
    public PhoneNumberPricing $pricing;

    #[Optional]
    public ?string $friendlyName;

    #[Optional]
    public ?string $locality;

    #[Optional]
    public ?string $region;

    /**
     * `new AvailablePhoneNumber()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AvailablePhoneNumber::with(capabilities: ..., phoneNumber: ..., pricing: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AvailablePhoneNumber)
     *   ->withCapabilities(...)
     *   ->withPhoneNumber(...)
     *   ->withPricing(...)
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
     * @param PhoneNumberCapabilities|PhoneNumberCapabilitiesShape $capabilities
     * @param PhoneNumberPricing|PhoneNumberPricingShape $pricing
     */
    public static function with(
        PhoneNumberCapabilities|array $capabilities,
        string $phoneNumber,
        PhoneNumberPricing|array $pricing,
        ?string $friendlyName = null,
        ?string $locality = null,
        ?string $region = null,
    ): self {
        $self = new self;

        $self['capabilities'] = $capabilities;
        $self['phoneNumber'] = $phoneNumber;
        $self['pricing'] = $pricing;

        null !== $friendlyName && $self['friendlyName'] = $friendlyName;
        null !== $locality && $self['locality'] = $locality;
        null !== $region && $self['region'] = $region;

        return $self;
    }

    /**
     * @param PhoneNumberCapabilities|PhoneNumberCapabilitiesShape $capabilities
     */
    public function withCapabilities(
        PhoneNumberCapabilities|array $capabilities
    ): self {
        $self = clone $this;
        $self['capabilities'] = $capabilities;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * @param PhoneNumberPricing|PhoneNumberPricingShape $pricing
     */
    public function withPricing(PhoneNumberPricing|array $pricing): self
    {
        $self = clone $this;
        $self['pricing'] = $pricing;

        return $self;
    }

    public function withFriendlyName(string $friendlyName): self
    {
        $self = clone $this;
        $self['friendlyName'] = $friendlyName;

        return $self;
    }

    public function withLocality(string $locality): self
    {
        $self = clone $this;
        $self['locality'] = $locality;

        return $self;
    }

    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }
}
