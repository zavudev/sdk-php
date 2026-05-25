<?php

declare(strict_types=1);

namespace Zavudev\Me\MeGetResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type TeamShape = array{id: string, name: string|null}
 */
final class Team implements BaseModel
{
    /** @use SdkModel<TeamShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public ?string $name;

    /**
     * `new Team()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Team::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Team)->withID(...)->withName(...)
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
    public static function with(string $id, ?string $name): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
