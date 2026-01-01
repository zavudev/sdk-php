<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent\Section;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type RowShape = array{
 *   id: string, title: string, description?: string|null
 * }
 */
final class Row implements BaseModel
{
    /** @use SdkModel<RowShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $title;

    #[Optional]
    public ?string $description;

    /**
     * `new Row()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Row::with(id: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Row)->withID(...)->withTitle(...)
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
        string $id,
        string $title,
        ?string $description = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['title'] = $title;

        null !== $description && $self['description'] = $description;

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

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
