<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Flows\FlowTrigger\Type;

/**
 * @phpstan-type FlowTriggerShape = array{
 *   type: Type|value-of<Type>, intent?: string|null, keywords?: list<string>|null
 * }
 */
final class FlowTrigger implements BaseModel
{
    /** @use SdkModel<FlowTriggerShape> */
    use SdkModel;

    /**
     * Type of trigger for a flow.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Intent that triggers the flow (for intent type).
     */
    #[Optional]
    public ?string $intent;

    /**
     * Keywords that trigger the flow (for keyword type).
     *
     * @var list<string>|null $keywords
     */
    #[Optional(list: 'string')]
    public ?array $keywords;

    /**
     * `new FlowTrigger()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowTrigger::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowTrigger)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param list<string>|null $keywords
     */
    public static function with(
        Type|string $type,
        ?string $intent = null,
        ?array $keywords = null
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $intent && $self['intent'] = $intent;
        null !== $keywords && $self['keywords'] = $keywords;

        return $self;
    }

    /**
     * Type of trigger for a flow.
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
     * Intent that triggers the flow (for intent type).
     */
    public function withIntent(string $intent): self
    {
        $self = clone $this;
        $self['intent'] = $intent;

        return $self;
    }

    /**
     * Keywords that trigger the flow (for keyword type).
     *
     * @param list<string> $keywords
     */
    public function withKeywords(array $keywords): self
    {
        $self = clone $this;
        $self['keywords'] = $keywords;

        return $self;
    }
}
