<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionTailLogsResponse\Event;

/**
 * @phpstan-import-type EventShape from \Zavudev\Functions\FunctionTailLogsResponse\Event
 *
 * @phpstan-type FunctionTailLogsResponseShape = array{
 *   events: list<Event|EventShape>, nextToken?: string|null
 * }
 */
final class FunctionTailLogsResponse implements BaseModel
{
    /** @use SdkModel<FunctionTailLogsResponseShape> */
    use SdkModel;

    /** @var list<Event> $events */
    #[Required(list: Event::class)]
    public array $events;

    /**
     * Pass to the next request to fetch the following page of logs.
     */
    #[Optional(nullable: true)]
    public ?string $nextToken;

    /**
     * `new FunctionTailLogsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionTailLogsResponse::with(events: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionTailLogsResponse)->withEvents(...)
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
     * @param list<Event|EventShape> $events
     */
    public static function with(array $events, ?string $nextToken = null): self
    {
        $self = new self;

        $self['events'] = $events;

        null !== $nextToken && $self['nextToken'] = $nextToken;

        return $self;
    }

    /**
     * @param list<Event|EventShape> $events
     */
    public function withEvents(array $events): self
    {
        $self = clone $this;
        $self['events'] = $events;

        return $self;
    }

    /**
     * Pass to the next request to fetch the following page of logs.
     */
    public function withNextToken(?string $nextToken): self
    {
        $self = clone $this;
        $self['nextToken'] = $nextToken;

        return $self;
    }
}
