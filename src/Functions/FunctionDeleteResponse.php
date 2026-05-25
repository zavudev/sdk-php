<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type FunctionDeleteResponseShape = array{
 *   deleted: bool, name?: string|null, slug?: string|null
 * }
 */
final class FunctionDeleteResponse implements BaseModel
{
    /** @use SdkModel<FunctionDeleteResponseShape> */
    use SdkModel;

    #[Required]
    public bool $deleted;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $slug;

    /**
     * `new FunctionDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionDeleteResponse::with(deleted: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionDeleteResponse)->withDeleted(...)
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
        bool $deleted,
        ?string $name = null,
        ?string $slug = null
    ): self {
        $self = new self;

        $self['deleted'] = $deleted;

        null !== $name && $self['name'] = $name;
        null !== $slug && $self['slug'] = $slug;

        return $self;
    }

    public function withDeleted(bool $deleted): self
    {
        $self = clone $this;
        $self['deleted'] = $deleted;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withSlug(string $slug): self
    {
        $self = clone $this;
        $self['slug'] = $slug;

        return $self;
    }
}
