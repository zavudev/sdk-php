<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type RequirementShape from \Zavudev\PhoneNumbers\Requirement
 *
 * @phpstan-type PhoneNumberRequirementsResponseShape = array{
 *   items: list<Requirement|RequirementShape>
 * }
 */
final class PhoneNumberRequirementsResponse implements BaseModel
{
    /** @use SdkModel<PhoneNumberRequirementsResponseShape> */
    use SdkModel;

    /** @var list<Requirement> $items */
    #[Required(list: Requirement::class)]
    public array $items;

    /**
     * `new PhoneNumberRequirementsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberRequirementsResponse::with(items: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberRequirementsResponse)->withItems(...)
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
     * @param list<Requirement|RequirementShape> $items
     */
    public static function with(array $items): self
    {
        $self = new self;

        $self['items'] = $items;

        return $self;
    }

    /**
     * @param list<Requirement|RequirementShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }
}
