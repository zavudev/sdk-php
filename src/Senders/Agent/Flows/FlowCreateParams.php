<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a new flow for an agent.
 *
 * @see Zavudev\Services\Senders\Agent\FlowsService::create()
 *
 * @phpstan-import-type FlowStepShape from \Zavudev\Senders\Agent\Flows\FlowStep
 * @phpstan-import-type FlowTriggerShape from \Zavudev\Senders\Agent\Flows\FlowTrigger
 *
 * @phpstan-type FlowCreateParamsShape = array{
 *   name: string,
 *   steps: list<FlowStep|FlowStepShape>,
 *   trigger: FlowTrigger|FlowTriggerShape,
 *   description?: string|null,
 *   enabled?: bool|null,
 *   priority?: int|null,
 * }
 */
final class FlowCreateParams implements BaseModel
{
    /** @use SdkModel<FlowCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $name;

    /** @var list<FlowStep> $steps */
    #[Required(list: FlowStep::class)]
    public array $steps;

    #[Required]
    public FlowTrigger $trigger;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?bool $enabled;

    #[Optional]
    public ?int $priority;

    /**
     * `new FlowCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowCreateParams::with(name: ..., steps: ..., trigger: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowCreateParams)->withName(...)->withSteps(...)->withTrigger(...)
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
     * @param list<FlowStep|FlowStepShape> $steps
     * @param FlowTrigger|FlowTriggerShape $trigger
     */
    public static function with(
        string $name,
        array $steps,
        FlowTrigger|array $trigger,
        ?string $description = null,
        ?bool $enabled = null,
        ?int $priority = null,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['steps'] = $steps;
        $self['trigger'] = $trigger;

        null !== $description && $self['description'] = $description;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $priority && $self['priority'] = $priority;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<FlowStep|FlowStepShape> $steps
     */
    public function withSteps(array $steps): self
    {
        $self = clone $this;
        $self['steps'] = $steps;

        return $self;
    }

    /**
     * @param FlowTrigger|FlowTriggerShape $trigger
     */
    public function withTrigger(FlowTrigger|array $trigger): self
    {
        $self = clone $this;
        $self['trigger'] = $trigger;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    public function withPriority(int $priority): self
    {
        $self = clone $this;
        $self['priority'] = $priority;

        return $self;
    }
}
