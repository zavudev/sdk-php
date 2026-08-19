<?php

declare(strict_types=1);

namespace Zavudev\Functions\Triggers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\Triggers\TriggerListResponse\Trigger;

/**
 * @phpstan-import-type TriggerShape from \Zavudev\Functions\Triggers\TriggerListResponse\Trigger
 *
 * @phpstan-type TriggerListResponseShape = array{
 *   triggers: list<Trigger|TriggerShape>
 * }
 */
final class TriggerListResponse implements BaseModel
{
    /** @use SdkModel<TriggerListResponseShape> */
    use SdkModel;

    /** @var list<Trigger> $triggers */
    #[Required(list: Trigger::class)]
    public array $triggers;

    /**
     * `new TriggerListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TriggerListResponse::with(triggers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TriggerListResponse)->withTriggers(...)
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
     * @param list<Trigger|TriggerShape> $triggers
     */
    public static function with(array $triggers): self
    {
        $self = new self;

        $self['triggers'] = $triggers;

        return $self;
    }

    /**
     * @param list<Trigger|TriggerShape> $triggers
     */
    public function withTriggers(array $triggers): self
    {
        $self = clone $this;
        $self['triggers'] = $triggers;

        return $self;
    }
}
