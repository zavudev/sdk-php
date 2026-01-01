<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A specific requirement type within a requirement group.
 *
 * @phpstan-import-type RequirementAcceptanceCriteriaShape from \Zavudev\PhoneNumbers\RequirementAcceptanceCriteria
 *
 * @phpstan-type RequirementTypeShape = array{
 *   id: string,
 *   description: string,
 *   name: string,
 *   type: RequirementFieldType|value-of<RequirementFieldType>,
 *   acceptanceCriteria?: null|RequirementAcceptanceCriteria|RequirementAcceptanceCriteriaShape,
 *   example?: string|null,
 * }
 */
final class RequirementType implements BaseModel
{
    /** @use SdkModel<RequirementTypeShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $description;

    #[Required]
    public string $name;

    /**
     * Type of requirement field.
     *
     * @var value-of<RequirementFieldType> $type
     */
    #[Required(enum: RequirementFieldType::class)]
    public string $type;

    /**
     * Acceptance criteria for a requirement.
     */
    #[Optional]
    public ?RequirementAcceptanceCriteria $acceptanceCriteria;

    #[Optional(nullable: true)]
    public ?string $example;

    /**
     * `new RequirementType()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RequirementType::with(id: ..., description: ..., name: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RequirementType)
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withName(...)
     *   ->withType(...)
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
     * @param RequirementFieldType|value-of<RequirementFieldType> $type
     * @param RequirementAcceptanceCriteria|RequirementAcceptanceCriteriaShape|null $acceptanceCriteria
     */
    public static function with(
        string $id,
        string $description,
        string $name,
        RequirementFieldType|string $type,
        RequirementAcceptanceCriteria|array|null $acceptanceCriteria = null,
        ?string $example = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['name'] = $name;
        $self['type'] = $type;

        null !== $acceptanceCriteria && $self['acceptanceCriteria'] = $acceptanceCriteria;
        null !== $example && $self['example'] = $example;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Type of requirement field.
     *
     * @param RequirementFieldType|value-of<RequirementFieldType> $type
     */
    public function withType(RequirementFieldType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Acceptance criteria for a requirement.
     *
     * @param RequirementAcceptanceCriteria|RequirementAcceptanceCriteriaShape $acceptanceCriteria
     */
    public function withAcceptanceCriteria(
        RequirementAcceptanceCriteria|array $acceptanceCriteria
    ): self {
        $self = clone $this;
        $self['acceptanceCriteria'] = $acceptanceCriteria;

        return $self;
    }

    public function withExample(?string $example): self
    {
        $self = clone $this;
        $self['example'] = $example;

        return $self;
    }
}
