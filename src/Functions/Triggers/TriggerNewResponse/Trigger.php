<?php

declare(strict_types=1);

namespace Zavudev\Functions\Triggers\TriggerNewResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A subscription that runs a Zavu Function when a messaging event fires.
 *
 * @phpstan-type TriggerShape = array{
 *   id: string,
 *   active: bool,
 *   createdAt: \DateTimeInterface,
 *   eventType: string,
 *   functionID: string,
 *   updatedAt: \DateTimeInterface,
 *   cron?: string|null,
 *   lastRunAt?: \DateTimeInterface|null,
 *   nextRunAt?: \DateTimeInterface|null,
 *   senderID?: string|null,
 * }
 */
final class Trigger implements BaseModel
{
    /** @use SdkModel<TriggerShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public bool $active;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Event type that fires the function. See GET /v1/functions/event-types for the supported list. The special type `cron` fires on a schedule instead of a messaging event and carries a `cron` expression.
     */
    #[Required]
    public string $eventType;

    #[Required('functionId')]
    public string $functionID;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * 5-field cron expression (minute hour day-of-month month day-of-week), evaluated in UTC. Present only on `cron` triggers.
     */
    #[Optional(nullable: true)]
    public ?string $cron;

    /**
     * Last time the schedule fired. Null until the first fire.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $lastRunAt;

    /**
     * Next scheduled fire time. Present only on `cron` triggers.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $nextRunAt;

    /**
     * Restrict the trigger to a single sender. Null means all senders in the project.
     */
    #[Optional('senderId', nullable: true)]
    public ?string $senderID;

    /**
     * `new Trigger()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Trigger::with(
     *   id: ...,
     *   active: ...,
     *   createdAt: ...,
     *   eventType: ...,
     *   functionID: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Trigger)
     *   ->withID(...)
     *   ->withActive(...)
     *   ->withCreatedAt(...)
     *   ->withEventType(...)
     *   ->withFunctionID(...)
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
     */
    public static function with(
        string $id,
        bool $active,
        \DateTimeInterface $createdAt,
        string $eventType,
        string $functionID,
        \DateTimeInterface $updatedAt,
        ?string $cron = null,
        ?\DateTimeInterface $lastRunAt = null,
        ?\DateTimeInterface $nextRunAt = null,
        ?string $senderID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['active'] = $active;
        $self['createdAt'] = $createdAt;
        $self['eventType'] = $eventType;
        $self['functionID'] = $functionID;
        $self['updatedAt'] = $updatedAt;

        null !== $cron && $self['cron'] = $cron;
        null !== $lastRunAt && $self['lastRunAt'] = $lastRunAt;
        null !== $nextRunAt && $self['nextRunAt'] = $nextRunAt;
        null !== $senderID && $self['senderID'] = $senderID;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withActive(bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Event type that fires the function. See GET /v1/functions/event-types for the supported list. The special type `cron` fires on a schedule instead of a messaging event and carries a `cron` expression.
     */
    public function withEventType(string $eventType): self
    {
        $self = clone $this;
        $self['eventType'] = $eventType;

        return $self;
    }

    public function withFunctionID(string $functionID): self
    {
        $self = clone $this;
        $self['functionID'] = $functionID;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * 5-field cron expression (minute hour day-of-month month day-of-week), evaluated in UTC. Present only on `cron` triggers.
     */
    public function withCron(?string $cron): self
    {
        $self = clone $this;
        $self['cron'] = $cron;

        return $self;
    }

    /**
     * Last time the schedule fired. Null until the first fire.
     */
    public function withLastRunAt(?\DateTimeInterface $lastRunAt): self
    {
        $self = clone $this;
        $self['lastRunAt'] = $lastRunAt;

        return $self;
    }

    /**
     * Next scheduled fire time. Present only on `cron` triggers.
     */
    public function withNextRunAt(?\DateTimeInterface $nextRunAt): self
    {
        $self = clone $this;
        $self['nextRunAt'] = $nextRunAt;

        return $self;
    }

    /**
     * Restrict the trigger to a single sender. Null means all senders in the project.
     */
    public function withSenderID(?string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
