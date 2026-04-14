<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Number10dlc\Brands\TenDlcBrand\EntityType;
use Zavudev\Number10dlc\Brands\TenDlcBrand\Status;

/**
 * @phpstan-type TenDlcBrandShape = array{
 *   id: string,
 *   city: string,
 *   country: string,
 *   createdAt: \DateTimeInterface,
 *   displayName: string,
 *   email: string,
 *   entityType: EntityType|value-of<EntityType>,
 *   phone: string,
 *   postalCode: string,
 *   state: string,
 *   status: Status|value-of<Status>,
 *   street: string,
 *   updatedAt: \DateTimeInterface,
 *   vertical: string,
 *   brandRelationship?: string|null,
 *   brandScore?: int|null,
 *   companyName?: string|null,
 *   ein?: string|null,
 *   failureReason?: string|null,
 *   firstName?: string|null,
 *   lastName?: string|null,
 *   stockExchange?: string|null,
 *   stockSymbol?: string|null,
 *   submittedAt?: \DateTimeInterface|null,
 *   verifiedAt?: \DateTimeInterface|null,
 *   website?: string|null,
 * }
 */
final class TenDlcBrand implements BaseModel
{
    /** @use SdkModel<TenDlcBrandShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $city;

    /**
     * Two-letter ISO country code.
     */
    #[Required]
    public string $country;

    #[Required]
    public \DateTimeInterface $createdAt;

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
     * Contact phone number in E.164 format.
     */
    #[Required]
    public string $phone;

    #[Required]
    public string $postalCode;

    #[Required]
    public string $state;

    /**
     * Status of a 10DLC brand registration.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public string $street;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * Industry vertical.
     */
    #[Required]
    public string $vertical;

    #[Optional(nullable: true)]
    public ?string $brandRelationship;

    /**
     * Trust score assigned by TCR after vetting.
     */
    #[Optional(nullable: true)]
    public ?int $brandScore;

    /**
     * Legal company name.
     */
    #[Optional(nullable: true)]
    public ?string $companyName;

    /**
     * Employer Identification Number (EIN).
     */
    #[Optional(nullable: true)]
    public ?string $ein;

    /**
     * Reason for rejection, if applicable.
     */
    #[Optional(nullable: true)]
    public ?string $failureReason;

    #[Optional(nullable: true)]
    public ?string $firstName;

    #[Optional(nullable: true)]
    public ?string $lastName;

    #[Optional(nullable: true)]
    public ?string $stockExchange;

    #[Optional(nullable: true)]
    public ?string $stockSymbol;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $submittedAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $verifiedAt;

    #[Optional(nullable: true)]
    public ?string $website;

    /**
     * `new TenDlcBrand()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TenDlcBrand::with(
     *   id: ...,
     *   city: ...,
     *   country: ...,
     *   createdAt: ...,
     *   displayName: ...,
     *   email: ...,
     *   entityType: ...,
     *   phone: ...,
     *   postalCode: ...,
     *   state: ...,
     *   status: ...,
     *   street: ...,
     *   updatedAt: ...,
     *   vertical: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TenDlcBrand)
     *   ->withID(...)
     *   ->withCity(...)
     *   ->withCountry(...)
     *   ->withCreatedAt(...)
     *   ->withDisplayName(...)
     *   ->withEmail(...)
     *   ->withEntityType(...)
     *   ->withPhone(...)
     *   ->withPostalCode(...)
     *   ->withState(...)
     *   ->withStatus(...)
     *   ->withStreet(...)
     *   ->withUpdatedAt(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        string $city,
        string $country,
        \DateTimeInterface $createdAt,
        string $displayName,
        string $email,
        EntityType|string $entityType,
        string $phone,
        string $postalCode,
        string $state,
        Status|string $status,
        string $street,
        \DateTimeInterface $updatedAt,
        string $vertical,
        ?string $brandRelationship = null,
        ?int $brandScore = null,
        ?string $companyName = null,
        ?string $ein = null,
        ?string $failureReason = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $stockExchange = null,
        ?string $stockSymbol = null,
        ?\DateTimeInterface $submittedAt = null,
        ?\DateTimeInterface $verifiedAt = null,
        ?string $website = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['city'] = $city;
        $self['country'] = $country;
        $self['createdAt'] = $createdAt;
        $self['displayName'] = $displayName;
        $self['email'] = $email;
        $self['entityType'] = $entityType;
        $self['phone'] = $phone;
        $self['postalCode'] = $postalCode;
        $self['state'] = $state;
        $self['status'] = $status;
        $self['street'] = $street;
        $self['updatedAt'] = $updatedAt;
        $self['vertical'] = $vertical;

        null !== $brandRelationship && $self['brandRelationship'] = $brandRelationship;
        null !== $brandScore && $self['brandScore'] = $brandScore;
        null !== $companyName && $self['companyName'] = $companyName;
        null !== $ein && $self['ein'] = $ein;
        null !== $failureReason && $self['failureReason'] = $failureReason;
        null !== $firstName && $self['firstName'] = $firstName;
        null !== $lastName && $self['lastName'] = $lastName;
        null !== $stockExchange && $self['stockExchange'] = $stockExchange;
        null !== $stockSymbol && $self['stockSymbol'] = $stockSymbol;
        null !== $submittedAt && $self['submittedAt'] = $submittedAt;
        null !== $verifiedAt && $self['verifiedAt'] = $verifiedAt;
        null !== $website && $self['website'] = $website;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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
     * Contact phone number in E.164 format.
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

    /**
     * Status of a 10DLC brand registration.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withStreet(string $street): self
    {
        $self = clone $this;
        $self['street'] = $street;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

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

    public function withBrandRelationship(?string $brandRelationship): self
    {
        $self = clone $this;
        $self['brandRelationship'] = $brandRelationship;

        return $self;
    }

    /**
     * Trust score assigned by TCR after vetting.
     */
    public function withBrandScore(?int $brandScore): self
    {
        $self = clone $this;
        $self['brandScore'] = $brandScore;

        return $self;
    }

    /**
     * Legal company name.
     */
    public function withCompanyName(?string $companyName): self
    {
        $self = clone $this;
        $self['companyName'] = $companyName;

        return $self;
    }

    /**
     * Employer Identification Number (EIN).
     */
    public function withEin(?string $ein): self
    {
        $self = clone $this;
        $self['ein'] = $ein;

        return $self;
    }

    /**
     * Reason for rejection, if applicable.
     */
    public function withFailureReason(?string $failureReason): self
    {
        $self = clone $this;
        $self['failureReason'] = $failureReason;

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

    public function withStockExchange(?string $stockExchange): self
    {
        $self = clone $this;
        $self['stockExchange'] = $stockExchange;

        return $self;
    }

    public function withStockSymbol(?string $stockSymbol): self
    {
        $self = clone $this;
        $self['stockSymbol'] = $stockSymbol;

        return $self;
    }

    public function withSubmittedAt(?\DateTimeInterface $submittedAt): self
    {
        $self = clone $this;
        $self['submittedAt'] = $submittedAt;

        return $self;
    }

    public function withVerifiedAt(?\DateTimeInterface $verifiedAt): self
    {
        $self = clone $this;
        $self['verifiedAt'] = $verifiedAt;

        return $self;
    }

    public function withWebsite(?string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }
}
