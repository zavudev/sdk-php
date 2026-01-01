<?php

declare(strict_types=1);

namespace Zavudev\Addresses;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A regulatory address for phone number requirements.
 *
 * @phpstan-type AddressShape = array{
 *   id: string,
 *   countryCode: string,
 *   createdAt: \DateTimeInterface,
 *   locality: string,
 *   postalCode: string,
 *   status: AddressStatus|value-of<AddressStatus>,
 *   streetAddress: string,
 *   administrativeArea?: string|null,
 *   businessName?: string|null,
 *   extendedAddress?: string|null,
 *   firstName?: string|null,
 *   lastName?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Address implements BaseModel
{
    /** @use SdkModel<AddressShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $countryCode;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $locality;

    #[Required]
    public string $postalCode;

    /** @var value-of<AddressStatus> $status */
    #[Required(enum: AddressStatus::class)]
    public string $status;

    #[Required]
    public string $streetAddress;

    #[Optional(nullable: true)]
    public ?string $administrativeArea;

    #[Optional(nullable: true)]
    public ?string $businessName;

    #[Optional(nullable: true)]
    public ?string $extendedAddress;

    #[Optional(nullable: true)]
    public ?string $firstName;

    #[Optional(nullable: true)]
    public ?string $lastName;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new Address()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Address::with(
     *   id: ...,
     *   countryCode: ...,
     *   createdAt: ...,
     *   locality: ...,
     *   postalCode: ...,
     *   status: ...,
     *   streetAddress: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Address)
     *   ->withID(...)
     *   ->withCountryCode(...)
     *   ->withCreatedAt(...)
     *   ->withLocality(...)
     *   ->withPostalCode(...)
     *   ->withStatus(...)
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
     *
     * @param AddressStatus|value-of<AddressStatus> $status
     */
    public static function with(
        string $id,
        string $countryCode,
        \DateTimeInterface $createdAt,
        string $locality,
        string $postalCode,
        AddressStatus|string $status,
        string $streetAddress,
        ?string $administrativeArea = null,
        ?string $businessName = null,
        ?string $extendedAddress = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['countryCode'] = $countryCode;
        $self['createdAt'] = $createdAt;
        $self['locality'] = $locality;
        $self['postalCode'] = $postalCode;
        $self['status'] = $status;
        $self['streetAddress'] = $streetAddress;

        null !== $administrativeArea && $self['administrativeArea'] = $administrativeArea;
        null !== $businessName && $self['businessName'] = $businessName;
        null !== $extendedAddress && $self['extendedAddress'] = $extendedAddress;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    /**
     * @param AddressStatus|value-of<AddressStatus> $status
     */
    public function withStatus(AddressStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withStreetAddress(string $streetAddress): self
    {
        $self = clone $this;
        $self['streetAddress'] = $streetAddress;

        return $self;
    }

    public function withAdministrativeArea(?string $administrativeArea): self
    {
        $self = clone $this;
        $self['administrativeArea'] = $administrativeArea;

        return $self;
    }

    public function withBusinessName(?string $businessName): self
    {
        $self = clone $this;
        $self['businessName'] = $businessName;

        return $self;
    }

    public function withExtendedAddress(?string $extendedAddress): self
    {
        $self = clone $this;
        $self['extendedAddress'] = $extendedAddress;

        return $self;
    }

    public function withFirstName(?string $firstName): self
    {
        $self = clone $this;
        $self['firstName'] = $firstName;

        return $self;
    }

    public function withLastName(?string $lastName): self
    {
        $self = clone $this;
        $self['lastName'] = $lastName;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
