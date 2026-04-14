<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\WhatsappSync\WhatsAppSyncStatus\Status;

/**
 * WhatsApp coexistence sync status.
 *
 * @phpstan-import-type WhatsAppSyncContactsShape from \Zavudev\Senders\WhatsappSync\WhatsAppSyncContacts
 * @phpstan-import-type WhatsAppSyncHistoryShape from \Zavudev\Senders\WhatsappSync\WhatsAppSyncHistory
 *
 * @phpstan-type WhatsAppSyncStatusShape = array{
 *   contacts: WhatsAppSyncContacts|WhatsAppSyncContactsShape,
 *   history: WhatsAppSyncHistory|WhatsAppSyncHistoryShape,
 *   isCoexistence: bool,
 *   status: Status|value-of<Status>,
 * }
 */
final class WhatsAppSyncStatus implements BaseModel
{
    /** @use SdkModel<WhatsAppSyncStatusShape> */
    use SdkModel;

    /**
     * Contacts sync status details.
     */
    #[Required]
    public WhatsAppSyncContacts $contacts;

    /**
     * History sync status details.
     */
    #[Required]
    public WhatsAppSyncHistory $history;

    /**
     * Whether the account is in coexistence mode.
     */
    #[Required]
    public bool $isCoexistence;

    /**
     * WhatsApp account status.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new WhatsAppSyncStatus()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsAppSyncStatus::with(
     *   contacts: ..., history: ..., isCoexistence: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsAppSyncStatus)
     *   ->withContacts(...)
     *   ->withHistory(...)
     *   ->withIsCoexistence(...)
     *   ->withStatus(...)
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
     * @param WhatsAppSyncContacts|WhatsAppSyncContactsShape $contacts
     * @param WhatsAppSyncHistory|WhatsAppSyncHistoryShape $history
     * @param Status|value-of<Status> $status
     */
    public static function with(
        WhatsAppSyncContacts|array $contacts,
        WhatsAppSyncHistory|array $history,
        bool $isCoexistence,
        Status|string $status,
    ): self {
        $self = new self;

        $self['contacts'] = $contacts;
        $self['history'] = $history;
        $self['isCoexistence'] = $isCoexistence;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Contacts sync status details.
     *
     * @param WhatsAppSyncContacts|WhatsAppSyncContactsShape $contacts
     */
    public function withContacts(WhatsAppSyncContacts|array $contacts): self
    {
        $self = clone $this;
        $self['contacts'] = $contacts;

        return $self;
    }

    /**
     * History sync status details.
     *
     * @param WhatsAppSyncHistory|WhatsAppSyncHistoryShape $history
     */
    public function withHistory(WhatsAppSyncHistory|array $history): self
    {
        $self = clone $this;
        $self['history'] = $history;

        return $self;
    }

    /**
     * Whether the account is in coexistence mode.
     */
    public function withIsCoexistence(bool $isCoexistence): self
    {
        $self = clone $this;
        $self['isCoexistence'] = $isCoexistence;

        return $self;
    }

    /**
     * WhatsApp account status.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
