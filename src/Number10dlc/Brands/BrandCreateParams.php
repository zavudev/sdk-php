<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Number10dlc\Brands\BrandCreateParams\EntityType;

/**
 * Create a 10DLC brand registration. The brand starts in draft status. Submit it for review using the submit endpoint.
 *
 * @see Zavudev\Services\Number10dlc\BrandsService::create()
 *
 * @phpstan-type BrandCreateParamsShape = array{
 *   city: string,
 *   country: string,
 *   displayName: string,
 *   email: string,
 *   entityType: EntityType|value-of<EntityType>,
 *   phone: string,
 *   postalCode: string,
 *   state: string,
 *   street: string,
 *   vertical: string,
 *   companyName?: string|null,
 *   ein?: string|null,
 *   firstName?: string|null,
 *   lastName?: string|null,
 *   stockExchange?: string|null,
 *   stockSymbol?: string|null,
 *   website?: string|null,
 * }
 */
final class BrandCreateParams implements BaseModel
{
    /** @use SdkModel<BrandCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $city;

    /**
     * Two-letter ISO country code.
     */
    #[Required]
    public string $country;

    /**
     * Display name of the brand.
     */
    #[Required]
    public string $displayName;

    #[Required]
    public string $email;

    /**
     * Business entity type for 10DLC brand registration.
     *
     * @var value-of<EntityType> $entityType
     */
    #[Required(enum: EntityType::class)]
    public string $entityType;

    /**
     * Contact phone in E.164 format.
     */
    #[Required]
    public string $phone;

    #[Required]
    public string $postalCode;

    #[Required]
    public string $state;

    #[Required]
    public string $street;

    /**
     * Industry vertical.
     */
    #[Required]
    public string $vertical;

    /**
     * Legal company name.
     */
    #[Optional]
    public ?string $companyName;

    /**
     * Employer Identification Number (format: XX-XXXXXXX).
     */
    #[Optional]
    public ?string $ein;

    #[Optional]
    public ?string $firstName;

    #[Optional]
    public ?string $lastName;

    #[Optional]
    public ?string $stockExchange;

    #[Optional]
    public ?string $stockSymbol;

    #[Optional]
    public ?string $website;

    /**
     * `new BrandCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrandCreateParams::with(
     *   city: ...,
     *   country: ...,
     *   displayName: ...,
     *   email: ...,
     *   entityType: ...,
     *   phone: ...,
     *   postalCode: ...,
     *   state: ...,
     *   street: ...,
     *   vertical: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrandCreateParams)
     *   ->withCity(...)
     *   ->withCountry(...)
     *   ->withDisplayName(...)
     *   ->withEmail(...)
     *   ->withEntityType(...)
     *   ->withPhone(...)
     *   ->withPostalCode(...)
     *   ->withState(...)
     *   ->withStreet(...)
     *   ->withVertical(...)
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
     * @param EntityType|value-of<EntityType> $entityType
     */
    public static function with(
        string $city,
        string $country,
        string $displayName,
        string $email,
        EntityType|string $entityType,
        string $phone,
        string $postalCode,
        string $state,
        string $street,
        string $vertical,
        ?string $companyName = null,
        ?string $ein = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $stockExchange = null,
        ?string $stockSymbol = null,
        ?string $website = null,
    ): self {
        $self = new self;

        $self['city'] = $city;
        $self['country'] = $country;
        $self['displayName'] = $displayName;
        $self['email'] = $email;
        $self['entityType'] = $entityType;
        $self['phone'] = $phone;
        $self['postalCode'] = $postalCode;
        $self['state'] = $state;
        $self['street'] = $street;
        $self['vertical'] = $vertical;

        null !== $companyName && $self['companyName'] = $companyName;
        null !== $ein && $self['ein'] = $ein;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $stockExchange && $self['stockExchange'] = $stockExchange;
        null !== $stockSymbol && $self['stockSymbol'] = $stockSymbol;
        null !== $website && $self['website'] = $website;

        return $self;
    }

    public function withCity(string $city): self
    {
        $self = clone $this;
        $self['city'] = $city;

        return $self;
    }

    /**
     * Two-letter ISO country code.
     */
    public function withCountry(string $country): self
    {
        $self = clone $this;
        $self['country'] = $country;

        return $self;
    }

    /**
     * Display name of the brand.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

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

    /**
     * Contact phone in E.164 format.
     */
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

    public function withStreet(string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    /**
     * Industry vertical.
     */
    public function withVertical(string $vertical): self
    {
        $self = clone $this;
        $self['vertical'] = $vertical;

        return $self;
    }

    /**
     * Legal company name.
     */
    public function withCompanyName(string $companyName): self
    {
        $self = clone $this;
        $self['companyName'] = $companyName;

        return $self;
    }

    /**
     * Employer Identification Number (format: XX-XXXXXXX).
     */
    public function withEin(string $ein): self
    {
        $self = clone $this;
        $self['ein'] = $ein;

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

    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }
}
