<?php

declare(strict_types=1);

namespace Zavudev\Me\MeGetResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ProjectShape = array{
 *   id: string, isSubAccount: bool, name: string|null
 * }
 */
final class Project implements BaseModel
{
    /** @use SdkModel<ProjectShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public bool $isSubAccount;

    #[Required]
    public ?string $name;

    /**
     * `new Project()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Project::with(id: ..., isSubAccount: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Project)->withID(...)->withIsSubAccount(...)->withName(...)
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
        bool $isSubAccount,
        ?string $name
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['isSubAccount'] = $isSubAccount;
        $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withIsSubAccount(bool $isSubAccount): self
    {
        $self = clone $this;
        $self['isSubAccount'] = $isSubAccount;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
