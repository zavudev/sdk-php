<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows\FlowUpdateParams;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step\Type;

/**
 * @phpstan-type StepShape = array{
 *   id: string,
 *   config: array<string,mixed>,
 *   type: Type|value-of<Type>,
 *   nextStepID?: string|null,
 * }
 */
final class Step implements BaseModel
{
    /** @use SdkModel<StepShape> */
    use SdkModel;

    /**
     * Unique step identifier.
     */
    #[Required]
    public string $id;

    /**
     * Step configuration (varies by type).
     *
     * @var array<string,mixed> $config
     */
    #[Required(map: 'mixed')]
    public array $config;

    /**
     * Type of flow step.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * ID of the next step to execute.
     */
    #[Optional('nextStepId', nullable: true)]
    public ?string $nextStepID;

    /**
     * `new Step()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Step::with(id: ..., config: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Step)->withID(...)->withConfig(...)->withType(...)
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
     * @param array<string,mixed> $config
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        array $config,
        Type|string $type,
        ?string $nextStepID = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['config'] = $config;
        $self['type'] = $type;

        null !== $nextStepID && $self['nextStepID'] = $nextStepID;

        return $self;
    }

    /**
     * Unique step identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Step configuration (varies by type).
     *
     * @param array<string,mixed> $config
     */
    public function withConfig(array $config): self
    {
        $self = clone $this;
        $self['config'] = $config;

        return $self;
    }

    /**
     * Type of flow step.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the next step to execute.
     */
    public function withNextStepID(?string $nextStepID): self
    {
        $self = clone $this;
        $self['nextStepID'] = $nextStepID;

        return $self;
    }
}
