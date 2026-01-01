<?php

declare(strict_types=1);

namespace Zavudev\Introspect\IntrospectValidatePhoneResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Introspect\LineType;

/**
 * Carrier information for the phone number.
 *
 * @phpstan-type CarrierShape = array{
 *   name?: string|null, type?: null|LineType|value-of<LineType>
 * }
 */
final class Carrier implements BaseModel
{
    /** @use SdkModel<CarrierShape> */
    use SdkModel;

    /**
     * Carrier name.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Type of phone line.
     *
     * @var value-of<LineType>|null $type
     */
    #[Optional(enum: LineType::class)]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param LineType|value-of<LineType>|null $type
     */
    public static function with(
        ?string $name = null,
        LineType|string|null $type = null
    ): self {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Carrier name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Type of phone line.
     *
     * @param LineType|value-of<LineType> $type
     */
    public function withType(LineType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
