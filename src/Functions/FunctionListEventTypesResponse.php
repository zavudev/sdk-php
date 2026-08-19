<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type FunctionListEventTypesResponseShape = array{events: list<string>}
 */
final class FunctionListEventTypesResponse implements BaseModel
{
    /** @use SdkModel<FunctionListEventTypesResponseShape> */
    use SdkModel;

    /** @var list<string> $events */
    #[Required(list: 'string')]
    public array $events;

    /**
     * `new FunctionListEventTypesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionListEventTypesResponse::with(events: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionListEventTypesResponse)->withEvents(...)
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
     * @param list<string> $events
     */
    public static function with(array $events): self
    {
        $self = new self;

        $self['events'] = $events;

        return $self;
    }

    /**
     * @param list<string> $events
     */
    public function withEvents(array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }
}
