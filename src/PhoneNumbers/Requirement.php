<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A group of requirements for a specific country/phone type combination.
 *
 * @phpstan-import-type RequirementTypeShape from \Zavudev\PhoneNumbers\RequirementType
 *
 * @phpstan-type RequirementShape = array{
 *   id: string,
 *   action: string,
 *   countryCode: string,
 *   phoneNumberType: string,
 *   requirementTypes: list<RequirementTypeShape>,
 * }
 */
final class Requirement implements BaseModel
{
    /** @use SdkModel<RequirementShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $action;

    #[Required]
    public string $countryCode;

    #[Required]
    public string $phoneNumberType;

    /** @var list<RequirementType> $requirementTypes */
    #[Required(list: RequirementType::class)]
    public array $requirementTypes;

    /**
     * `new Requirement()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Requirement::with(
     *   id: ...,
     *   action: ...,
     *   countryCode: ...,
     *   phoneNumberType: ...,
     *   requirementTypes: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Requirement)
     *   ->withID(...)
     *   ->withAction(...)
     *   ->withCountryCode(...)
     *   ->withPhoneNumberType(...)
     *   ->withRequirementTypes(...)
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
     * @param list<RequirementTypeShape> $requirementTypes
     */
    public static function with(
        string $id,
        string $action,
        string $countryCode,
        string $phoneNumberType,
        array $requirementTypes,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['action'] = $action;
        $self['countryCode'] = $countryCode;
        $self['phoneNumberType'] = $phoneNumberType;
        $self['requirementTypes'] = $requirementTypes;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAction(string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withPhoneNumberType(string $phoneNumberType): self
    {
        $self = clone $this;
        $self['phoneNumberType'] = $phoneNumberType;

        return $self;
    }

    /**
     * @param list<RequirementTypeShape> $requirementTypes
     */
    public function withRequirementTypes(array $requirementTypes): self
    {
        $self = clone $this;
        $self['requirementTypes'] = $requirementTypes;

        return $self;
    }
}
