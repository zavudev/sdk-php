<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers\PhoneNumberPurchaseParams;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type RegulatoryRequirementShape = array{
 *   fieldValue: string, requirementType: string
 * }
 */
final class RegulatoryRequirement implements BaseModel
{
    /** @use SdkModel<RegulatoryRequirementShape> */
    use SdkModel;

    /**
     * Depends on the requirement's `type`: the text itself for `textual`; for `address`, the `id` of an address created in this project with `POST /v1/addresses`; for `document`, the `id` of a document created with `POST /v1/documents`. An address or document from another project, or one rejected in review, is refused.
     */
    #[Required]
    public string $fieldValue;

    /**
     * A `requirementTypes[].id` from `GET /v1/phone-numbers/requirements`. Each id may appear only once.
     */
    #[Required]
    public string $requirementType;

    /**
     * `new RegulatoryRequirement()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RegulatoryRequirement::with(fieldValue: ..., requirementType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RegulatoryRequirement)->withFieldValue(...)->withRequirementType(...)
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
        string $fieldValue,
        string $requirementType
    ): self {
        $self = new self;

        $self['fieldValue'] = $fieldValue;
        $self['requirementType'] = $requirementType;

        return $self;
    }

    /**
     * Depends on the requirement's `type`: the text itself for `textual`; for `address`, the `id` of an address created in this project with `POST /v1/addresses`; for `document`, the `id` of a document created with `POST /v1/documents`. An address or document from another project, or one rejected in review, is refused.
     */
    public function withFieldValue(string $fieldValue): self
    {
        $self = clone $this;
        $self['fieldValue'] = $fieldValue;

        return $self;
    }

    /**
     * A `requirementTypes[].id` from `GET /v1/phone-numbers/requirements`. Each id may appear only once.
     */
    public function withRequirementType(string $requirementType): self
    {
        $self = clone $this;
        $self['requirementType'] = $requirementType;

        return $self;
    }
}
