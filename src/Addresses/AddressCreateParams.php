<?php

declare(strict_types=1);

namespace Zavudev\Addresses;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a regulatory address, to use as the value of an `address` requirement when buying a phone number. It is registered for review when it is created, with status `pending`.
 *
 * @see Zavudev\Services\AddressesService::create()
 *
 * @phpstan-type AddressCreateParamsShape = array{
 *   countryCode: string,
 *   firstName: string,
 *   lastName: string,
 *   locality: string,
 *   postalCode: string,
 *   streetAddress: string,
 *   administrativeArea?: string|null,
 *   businessName?: string|null,
 *   extendedAddress?: string|null,
 * }
 */
final class AddressCreateParams implements BaseModel
{
    /** @use SdkModel<AddressCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $countryCode;

    /**
     * First name of the person the address is registered to.
     */
    #[Required]
    public string $firstName;

    /**
     * Last name of the person the address is registered to.
     */
    #[Required]
    public string $lastName;

    #[Required]
    public string $locality;

    #[Required]
    public string $postalCode;

    #[Required]
    public string $streetAddress;

    #[Optional]
    public ?string $administrativeArea;

    /**
     * Business name, when the address belongs to a business. Defaults to the person's full name.
     */
    #[Optional]
    public ?string $businessName;

    #[Optional]
    public ?string $extendedAddress;

    /**
     * `new AddressCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AddressCreateParams::with(
     *   countryCode: ...,
     *   firstName: ...,
     *   lastName: ...,
     *   locality: ...,
     *   postalCode: ...,
     *   streetAddress: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AddressCreateParams)
     *   ->withCountryCode(...)
     *   ->withFirstName(...)
     *   ->withLastName(...)
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
        string $firstName,
        string $lastName,
        string $locality,
        string $postalCode,
        string $streetAddress,
        ?string $administrativeArea = null,
        ?string $businessName = null,
        ?string $extendedAddress = null,
    ): self {
        $self = new self;

        $self['countryCode'] = $countryCode;
        $self['firstName'] = $firstName;
        $self['lastName'] = $lastName;
        $self['locality'] = $locality;
        $self['postalCode'] = $postalCode;
        $self['streetAddress'] = $streetAddress;

        null !== $administrativeArea && $self['administrativeArea'] = $administrativeArea;
        null !== $businessName && $self['businessName'] = $businessName;
        null !== $extendedAddress && $self['extendedAddress'] = $extendedAddress;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * First name of the person the address is registered to.
     */
    public function withFirstName(string $firstName): self
    {
        $self = clone $this;
        $self['firstName'] = $firstName;

        return $self;
    }

    /**
     * Last name of the person the address is registered to.
     */
    public function withLastName(string $lastName): self
    {
        $self = clone $this;
        $self['lastName'] = $lastName;

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

    /**
     * Business name, when the address belongs to a business. Defaults to the person's full name.
     */
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
}
