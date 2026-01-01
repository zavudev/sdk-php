<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ButtonShape = array{id: string, title: string}
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $title;

    /**
     * `new Button()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Button::with(id: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Button)->withID(...)->withTitle(...)
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
    public static function with(string $id, string $title): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['title'] = $title;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
