<?php

declare(strict_types=1);

namespace Zavudev\Functions\Triggers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Core\Conversion\ListOf;

/**
 * Subscribe a function to one or more event types, optionally scoped to specific senders. Provide eventTypes and senderIds (use null in senderIds for all senders); a trigger is created for each event type and sender combination.
 *
 * The special event type `cron` runs the function on a schedule instead of a messaging event: include a `cron` field with a 5-field UTC cron expression (minimum granularity one minute). A cron trigger ignores the sender axis, and a function may hold several cron triggers with different expressions. The function receives an event with `type: "cron"` and `data.cron`.
 *
 * @see Zavudev\Services\Functions\TriggersService::create()
 *
 * @phpstan-type TriggerCreateParamsShape = array{
 *   eventTypes: list<string>, senderIDs: list<string|null>, cron?: string|null
 * }
 */
final class TriggerCreateParams implements BaseModel
{
    /** @use SdkModel<TriggerCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Event types to subscribe to.
     *
     * @var list<string> $eventTypes
     */
    #[Required(list: 'string')]
    public array $eventTypes;

    /**
     * Senders to scope the triggers to. Use null for all senders.
     *
     * @var list<string|null> $senderIDs
     */
    #[Required('senderIds', type: new ListOf('string', nullable: true))]
    public array $senderIDs;

    /**
     * Required when eventTypes includes `cron`: a 5-field cron expression (minute hour day-of-month month day-of-week), evaluated in UTC.
     */
    #[Optional]
    public ?string $cron;

    /**
     * `new TriggerCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TriggerCreateParams::with(eventTypes: ..., senderIDs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TriggerCreateParams)->withEventTypes(...)->withSenderIDs(...)
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
     * @param list<string> $eventTypes
     * @param list<string|null> $senderIDs
     */
    public static function with(
        array $eventTypes,
        array $senderIDs,
        ?string $cron = null
    ): self {
        $self = new self;

        $self['eventTypes'] = $eventTypes;
        $self['senderIDs'] = $senderIDs;

        null !== $cron && $self['cron'] = $cron;

        return $self;
    }

    /**
     * Event types to subscribe to.
     *
     * @param list<string> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * Senders to scope the triggers to. Use null for all senders.
     *
     * @param list<string|null> $senderIDs
     */
    public function withSenderIDs(array $senderIDs): self
    {
        $self = clone $this;
        $self['senderIDs'] = $senderIDs;

        return $self;
    }

    /**
     * Required when eventTypes includes `cron`: a 5-field cron expression (minute hour day-of-month month day-of-week), evaluated in UTC.
     */
    public function withCron(string $cron): self
    {
        $self = clone $this;
        $self['cron'] = $cron;

        return $self;
    }
}
