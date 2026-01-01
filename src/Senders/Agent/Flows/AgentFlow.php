<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Flows\AgentFlow\Step;
use Zavudev\Senders\Agent\Flows\AgentFlow\Trigger;

/**
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\AgentFlow\Step
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\AgentFlow\Trigger
 *
 * @phpstan-type AgentFlowShape = array{
 *   id: string,
 *   agentID: string,
 *   createdAt: \DateTimeInterface,
 *   enabled: bool,
 *   name: string,
 *   priority: int,
 *   steps: list<StepShape>,
 *   trigger: Trigger|TriggerShape,
 *   updatedAt: \DateTimeInterface,
 *   description?: string|null,
 * }
 */
final class AgentFlow implements BaseModel
{
    /** @use SdkModel<AgentFlowShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('agentId')]
    public string $agentID;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public bool $enabled;

    #[Required]
    public string $name;

    /**
     * Priority when multiple flows match (higher = more priority).
     */
    #[Required]
    public int $priority;

    /** @var list<Step> $steps */
    #[Required(list: Step::class)]
    public array $steps;

    #[Required]
    public Trigger $trigger;

    #[Required]
    public \DateTimeInterface $updatedAt;

    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * `new AgentFlow()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentFlow::with(
     *   id: ...,
     *   agentID: ...,
     *   createdAt: ...,
     *   enabled: ...,
     *   name: ...,
     *   priority: ...,
     *   steps: ...,
     *   trigger: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentFlow)
     *   ->withID(...)
     *   ->withAgentID(...)
     *   ->withCreatedAt(...)
     *   ->withEnabled(...)
     *   ->withName(...)
     *   ->withPriority(...)
     *   ->withSteps(...)
     *   ->withTrigger(...)
     *   ->withUpdatedAt(...)
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
     * @param list<StepShape> $steps
     * @param Trigger|TriggerShape $trigger
     */
    public static function with(
        string $id,
        string $agentID,
        \DateTimeInterface $createdAt,
        bool $enabled,
        string $name,
        int $priority,
        array $steps,
        Trigger|array $trigger,
        \DateTimeInterface $updatedAt,
        ?string $description = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentID'] = $agentID;
        $self['createdAt'] = $createdAt;
        $self['enabled'] = $enabled;
        $self['name'] = $name;
        $self['priority'] = $priority;
        $self['steps'] = $steps;
        $self['trigger'] = $trigger;
        $self['updatedAt'] = $updatedAt;

        null !== $description && $self['description'] = $description;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Priority when multiple flows match (higher = more priority).
     */
    public function withPriority(int $priority): self
    {
        $self = clone $this;
        $self['priority'] = $priority;

        return $self;
    }

    /**
     * @param list<StepShape> $steps
     */
    public function withSteps(array $steps): self
    {
        $self = clone $this;
        $self['steps'] = $steps;

        return $self;
    }

    /**
     * @param Trigger|TriggerShape $trigger
     */
    public function withTrigger(Trigger|array $trigger): self
    {
        $self = clone $this;
        $self['trigger'] = $trigger;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
