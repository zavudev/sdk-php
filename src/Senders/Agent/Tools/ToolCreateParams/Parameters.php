<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools\ToolCreateParams;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters\Property;
use Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters\Type;

/**
 * @phpstan-import-type PropertyShape from \Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters\Property
 *
 * @phpstan-type ParametersShape = array{
 *   properties: array<string,Property|PropertyShape>,
 *   required: list<string>,
 *   type: Type|value-of<Type>,
 * }
 */
final class Parameters implements BaseModel
{
    /** @use SdkModel<ParametersShape> */
    use SdkModel;

    /** @var array<string,Property> $properties */
    #[Required(map: Property::class)]
    public array $properties;

    /** @var list<string> $required */
    #[Required(list: 'string')]
    public array $required;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new Parameters()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Parameters::with(properties: ..., required: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Parameters)->withProperties(...)->withRequired(...)->withType(...)
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
     * @param array<string,Property|PropertyShape> $properties
     * @param list<string> $required
     * @param Type|value-of<Type> $type
     */
    public static function with(
        array $properties,
        array $required,
        Type|string $type
    ): self {
        $self = new self;

        $self['properties'] = $properties;
        $self['required'] = $required;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param array<string,Property|PropertyShape> $properties
     */
    public function withProperties(array $properties): self
    {
        $self = clone $this;
        $self['properties'] = $properties;

        return $self;
    }

    /**
     * @param list<string> $required
     */
    public function withRequired(array $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
