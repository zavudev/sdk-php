<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Number10dlc\Brands\BrandUpdateParams\EntityType;

/**
 * Update a 10DLC brand in draft status. Cannot update after submission.
 *
 * @see Zavudev\Services\Number10dlc\BrandsService::update()
 *
 * @phpstan-type BrandUpdateParamsShape = array{
 *   city?: string|null,
 *   companyName?: string|null,
 *   country?: string|null,
 *   displayName?: string|null,
 *   ein?: string|null,
 *   email?: string|null,
 *   entityType?: null|EntityType|value-of<EntityType>,
 *   firstName?: string|null,
 *   lastName?: string|null,
 *   phone?: string|null,
 *   postalCode?: string|null,
 *   state?: string|null,
 *   stockExchange?: string|null,
 *   stockSymbol?: string|null,
 *   street?: string|null,
 *   vertical?: string|null,
 *   website?: string|null,
 * }
 */
final class BrandUpdateParams implements BaseModel
{
    /** @use SdkModel<BrandUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $city;

    #[Optional]
    public ?string $companyName;

    #[Optional]
    public ?string $country;

    #[Optional]
    public ?string $displayName;

    #[Optional]
    public ?string $ein;

    #[Optional]
    public ?string $email;

    /**
     * Business entity type for 10DLC brand registration.
     *
     * @var value-of<EntityType>|null $entityType
     */
    #[Optional(enum: EntityType::class)]
    public ?string $entityType;

    #[Optional]
    public ?string $firstName;

    #[Optional]
    public ?string $lastName;

    #[Optional]
    public ?string $phone;

    #[Optional]
    public ?string $postalCode;

    #[Optional]
    public ?string $state;

    #[Optional]
    public ?string $stockExchange;

    #[Optional]
    public ?string $stockSymbol;

    #[Optional]
    public ?string $street;

    #[Optional]
    public ?string $vertical;

    #[Optional]
    public ?string $website;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param EntityType|value-of<EntityType>|null $entityType
     */
    public static function with(
        ?string $city = null,
        ?string $companyName = null,
        ?string $country = null,
        ?string $displayName = null,
        ?string $ein = null,
        ?string $email = null,
        EntityType|string|null $entityType = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        ?string $postalCode = null,
        ?string $state = null,
        ?string $stockExchange = null,
        ?string $stockSymbol = null,
        ?string $street = null,
        ?string $vertical = null,
        ?string $website = null,
    ): self {
        $self = new self;

        null !== $city && $self['city'] = $city;
        null !== $companyName && $self['companyName'] = $companyName;
        null !== $country && $self['country'] = $country;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $ein && $self['ein'] = $ein;
        null !== $email && $self['email'] = $email;
        null !== $entityType && $self['entityType'] = $entityType;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $phone && $self['phone'] = $phone;
        null !== $postalCode && $self['postalCode'] = $postalCode;
        null !== $state && $self['state'] = $state;
        null !== $stockExchange && $self['stockExchange'] = $stockExchange;
        null !== $stockSymbol && $self['stockSymbol'] = $stockSymbol;
        null !== $street && $self['street'] = $street;
        null !== $vertical && $self['vertical'] = $vertical;
        null !== $website && $self['website'] = $website;

        return $self;
    }

    public function withCity(string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    public function withCompanyName(string $companyName): self
    {
        $self = clone $this;
        $self['companyName'] = $companyName;

        return $self;
    }

    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    public function withEin(string $ein): self
    {
        $self = clone $this;
        $self['ein'] = $ein;

        return $self;
    }

    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Business entity type for 10DLC brand registration.
     *
     * @param EntityType|value-of<EntityType> $entityType
     */
    public function withEntityType(EntityType|string $entityType): self
    {
        $self = clone $this;
        $self['entityType'] = $entityType;

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

    public function withPhone(string $phone): self
    {
        $self = clone $this;
        $self['phone'] = $phone;

        return $self;
    }

    public function withPostalCode(string $postalCode): self
    {
        $self = clone $this;
        $self['postalCode'] = $postalCode;

        return $self;
    }

    public function withState(string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    public function withStockExchange(string $stockExchange): self
    {
        $self = clone $this;
        $self['stockExchange'] = $stockExchange;

        return $self;
    }

    public function withStockSymbol(string $stockSymbol): self
    {
        $self = clone $this;
        $self['stockSymbol'] = $stockSymbol;

        return $self;
    }

    public function withStreet(string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    public function withVertical(string $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }

    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }
}
