<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type WhatsAppSyncStatusShape from \Zavudev\Senders\WhatsappSync\WhatsAppSyncStatus
 *
 * @phpstan-type WhatsappSyncStartHistorySyncResponseShape = array{
 *   message: string, sync: WhatsAppSyncStatus|WhatsAppSyncStatusShape
 * }
 */
final class WhatsappSyncStartHistorySyncResponse implements BaseModel
{
    /** @use SdkModel<WhatsappSyncStartHistorySyncResponseShape> */
    use SdkModel;

    /**
     * Success message.
     */
    #[Required]
    public string $message;

    /**
     * WhatsApp coexistence sync status.
     */
    #[Required]
    public WhatsAppSyncStatus $sync;

    /**
     * `new WhatsappSyncStartHistorySyncResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsappSyncStartHistorySyncResponse::with(message: ..., sync: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsappSyncStartHistorySyncResponse)->withMessage(...)->withSync(...)
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
     * @param WhatsAppSyncStatus|WhatsAppSyncStatusShape $sync
     */
    public static function with(
        string $message,
        WhatsAppSyncStatus|array $sync
    ): self {
        $self = new self;

        $self['message'] = $message;
        $self['sync'] = $sync;

        return $self;
    }

    /**
     * Success message.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * WhatsApp coexistence sync status.
     *
     * @param WhatsAppSyncStatus|WhatsAppSyncStatusShape $sync
     */
    public function withSync(WhatsAppSyncStatus|array $sync): self
    {
        $self = clone $this;
        $self['sync'] = $sync;

        return $self;
    }
}
