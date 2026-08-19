<?php

declare(strict_types=1);

namespace Zavudev\Agents\AgentTestParams;

use Zavudev\Agents\AgentTestParams\History\Role;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type HistoryShape = array{content: string, role: Role|value-of<Role>}
 */
final class History implements BaseModel
{
    /** @use SdkModel<HistoryShape> */
    use SdkModel;

    #[Required]
    public string $content;

    /** @var value-of<Role> $role */
    #[Required(enum: Role::class)]
    public string $role;

    /**
     * `new History()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * History::with(content: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new History)->withContent(...)->withRole(...)
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
     * @param Role|value-of<Role> $role
     */
    public static function with(string $content, Role|string $role): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['role'] = $role;

        return $self;
    }

    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
