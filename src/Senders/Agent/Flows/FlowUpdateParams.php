<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step;
use Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger;

/**
 * Update a flow.
 *
 * @see Zavudev\Services\Senders\Agent\FlowsService::update()
 *
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger
 *
 * @phpstan-type FlowUpdateParamsShape = array{
 *   senderID: string,
 *   description?: string|null,
 *   enabled?: bool|null,
 *   name?: string|null,
 *   priority?: int|null,
 *   steps?: list<StepShape>|null,
 *   trigger?: null|Trigger|TriggerShape,
 * }
 */
final class FlowUpdateParams implements BaseModel
{
    /** @use SdkModel<FlowUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?bool $enabled;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?int $priority;

    /** @var list<Step>|null $steps */
    #[Optional(list: Step::class)]
    public ?array $steps;

    #[Optional]
    public ?Trigger $trigger;

    /**
     * `new FlowUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowUpdateParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowUpdateParams)->withSenderID(...)
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
     * @param list<StepShape>|null $steps
     * @param Trigger|TriggerShape|null $trigger
     */
    public static function with(
        string $senderID,
        ?string $description = null,
        ?bool $enabled = null,
        ?string $name = null,
        ?int $priority = null,
        ?array $steps = null,
        Trigger|array|null $trigger = null,
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;

        null !== $description && $self['description'] = $description;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $name && $self['name'] = $name;
        null !== $priority && $self['priority'] = $priority;
        null !== $steps && $self['steps'] = $steps;
        null !== $trigger && $self['trigger'] = $trigger;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

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

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

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
}
