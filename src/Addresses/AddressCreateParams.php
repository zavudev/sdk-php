<?php

declare(strict_types=1);

namespace Zavudev\Addresses;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a regulatory address for phone number purchases. Some countries require a verified address before phone numbers can be activated.
 *
 * @see Zavudev\Services\AddressesService::create()
 *
 * @phpstan-type AddressCreateParamsShape = array{
 *   countryCode: string,
 *   locality: string,
 *   postalCode: string,
 *   streetAddress: string,
 *   administrativeArea?: string|null,
 *   businessName?: string|null,
 *   extendedAddress?: string|null,
 *   firstName?: string|null,
 *   lastName?: string|null,
 * }
 */
final class AddressCreateParams implements BaseModel
{
    /** @use SdkModel<AddressCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $countryCode;

    #[Required]
    public string $locality;

    #[Required]
    public string $postalCode;

    #[Required]
    public string $streetAddress;

    #[Optional]
    public ?string $administrativeArea;

    #[Optional]
    public ?string $businessName;

    #[Optional]
    public ?string $extendedAddress;

    #[Optional]
    public ?string $firstName;

    #[Optional]
    public ?string $lastName;

    /**
     * `new AddressCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AddressCreateParams::with(
     *   countryCode: ..., locality: ..., postalCode: ..., streetAddress: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AddressCreateParams)
     *   ->withCountryCode(...)
     *   ->withLocality(...)
     *   ->withPostalCode(...)
     *   ->withStreetAddress(...)
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
        string $countryCode,
        string $locality,
        string $postalCode,
        string $streetAddress,
        ?string $administrativeArea = null,
        ?string $businessName = null,
        ?string $extendedAddress = null,
        ?string $firstName = null,
        ?string $lastName = null,
    ): self {
        $self = new self;

        $self['countryCode'] = $countryCode;
        $self['locality'] = $locality;
        $self['postalCode'] = $postalCode;
        $self['streetAddress'] = $streetAddress;

        null !== $administrativeArea && $self['administrativeArea'] = $administrativeArea;
        null !== $businessName && $self['businessName'] = $businessName;
        null !== $extendedAddress && $self['extendedAddress'] = $extendedAddress;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $lastName && $self['lastName'] = $lastName;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withLocality(string $locality): self
    {
        $self = clone $this;
        $self['locality'] = $locality;

        return $self;
    }

    public function withPostalCode(string $postalCode): self
    {
        $self = clone $this;
        $self['postalCode'] = $postalCode;

        return $self;
    }

    public function withStreetAddress(string $streetAddress): self
    {
        $self = clone $this;
        $self['streetAddress'] = $streetAddress;

        return $self;
    }

    public function withAdministrativeArea(string $administrativeArea): self
    {
        $self = clone $this;
        $self['administrativeArea'] = $administrativeArea;

        return $self;
    }

    public function withBusinessName(string $businessName): self
    {
        $self = clone $this;
        $self['businessName'] = $businessName;

        return $self;
    }

    public function withExtendedAddress(string $extendedAddress): self
    {
        $self = clone $this;
        $self['extendedAddress'] = $extendedAddress;

        return $self;
    }

    public function withFirstName(string $firstName): self
    {
        $self = clone $this;
        $self['firstName'] = $firstName;

        return $self;
    }

    public function withLastName(string $lastName): self
    {
        $self = clone $this;
        $self['lastName'] = $lastName;

        return $self;
    }
}
