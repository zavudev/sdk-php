<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\WhatsappSync\WhatsAppSyncContacts\Status;

/**
 * Contacts sync status details.
 *
 * @phpstan-type WhatsAppSyncContactsShape = array{
 *   canSync: bool,
 *   status: Status|value-of<Status>,
 *   requestedAt?: \DateTimeInterface|null,
 * }
 */
final class WhatsAppSyncContacts implements BaseModel
{
    /** @use SdkModel<WhatsAppSyncContactsShape> */
    use SdkModel;

    /**
     * Whether contacts sync can be initiated.
     */
    #[Required]
    public bool $canSync;

    /**
     * Status of WhatsApp contacts sync.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * When the sync was last requested.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $requestedAt;

    /**
     * `new WhatsAppSyncContacts()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsAppSyncContacts::with(canSync: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsAppSyncContacts)->withCanSync(...)->withStatus(...)
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
        ?\DateTimeInterface $requestedAt = null,
    ): self {
        $self = new self;

        $self['canSync'] = $canSync;
        $self['status'] = $status;

        null !== $requestedAt && $self['requestedAt'] = $requestedAt;

        return $self;
    }

    /**
     * Whether contacts sync can be initiated.
     */
    public function withCanSync(bool $canSync): self
    {
        $self = clone $this;
        $self['canSync'] = $canSync;

        return $self;
    }

    /**
     * Status of WhatsApp contacts sync.
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
     * When the sync was last requested.
     */
    public function withRequestedAt(?\DateTimeInterface $requestedAt): self
    {
        $self = clone $this;
        $self['requestedAt'] = $requestedAt;

        return $self;
    }
}
