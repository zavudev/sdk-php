<?php

declare(strict_types=1);

namespace Zavudev\Agents\AgentTestResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExecutedToolCallShape = array{
 *   name: string, ok: bool, error?: string|null
 * }
 */
final class ExecutedToolCall implements BaseModel
{
    /** @use SdkModel<ExecutedToolCallShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required]
    public bool $ok;

    #[Optional(nullable: true)]
    public ?string $error;

    /**
     * `new ExecutedToolCall()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExecutedToolCall::with(name: ..., ok: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExecutedToolCall)->withName(...)->withOk(...)
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
        string $name,
        bool $ok,
        ?string $error = null
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['ok'] = $ok;

        null !== $error && $self['error'] = $error;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withOk(bool $ok): self
    {
        $self = clone $this;
        $self['ok'] = $ok;

        return $self;
    }

    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }
}
