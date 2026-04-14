<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\WhatsappSync\WhatsAppSyncHistory\Status;

/**
 * History sync status details.
 *
 * @phpstan-type WhatsAppSyncHistoryShape = array{
 *   canSync: bool,
 *   status: Status|value-of<Status>,
 *   completedAt?: \DateTimeInterface|null,
 *   requestedAt?: \DateTimeInterface|null,
 * }
 */
final class WhatsAppSyncHistory implements BaseModel
{
    /** @use SdkModel<WhatsAppSyncHistoryShape> */
    use SdkModel;

    /**
     * Whether history sync can be initiated.
     */
    #[Required]
    public bool $canSync;

    /**
     * Status of WhatsApp message history sync.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * When the sync was completed.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $completedAt;

    /**
     * When the sync was last requested.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $requestedAt;

    /**
     * `new WhatsAppSyncHistory()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsAppSyncHistory::with(canSync: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsAppSyncHistory)->withCanSync(...)->withStatus(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        bool $canSync,
        Status|string $status,
        ?\DateTimeInterface $completedAt = null,
        ?\DateTimeInterface $requestedAt = null,
    ): self {
        $self = new self;

        $self['canSync'] = $canSync;
        $self['status'] = $status;

        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $requestedAt && $self['requestedAt'] = $requestedAt;

        return $self;
    }

    /**
     * Whether history sync can be initiated.
     */
    public function withCanSync(bool $canSync): self
    {
        $self = clone $this;
        $self['canSync'] = $canSync;

        return $self;
    }

    /**
     * Status of WhatsApp message history sync.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * When the sync was completed.
     */
    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    /**
     * When the sync was last requested.
     */
    public function withRequestedAt(?\DateTimeInterface $requestedAt): self
    {
        $self = clone $this;
        $self['requestedAt'] = $requestedAt;

        return $self;
    }
}
