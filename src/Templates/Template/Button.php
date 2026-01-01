<?php

declare(strict_types=1);

namespace Zavudev\Templates\Template;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ButtonShape = array{
 *   phoneNumber?: string|null,
 *   text?: string|null,
 *   type?: string|null,
 *   url?: string|null,
 * }
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    #[Optional]
    public ?string $phoneNumber;

    #[Optional]
    public ?string $text;

    #[Optional]
    public ?string $type;

    #[Optional]
    public ?string $url;

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
        ?string $phoneNumber = null,
        ?string $text = null,
        ?string $type = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $text && $self['text'] = $text;
        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
