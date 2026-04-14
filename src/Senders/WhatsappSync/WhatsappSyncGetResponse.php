<?php

declare(strict_types=1);

namespace Zavudev\Senders\WhatsappSync;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type WhatsAppSyncStatusShape from \Zavudev\Senders\WhatsappSync\WhatsAppSyncStatus
 *
 * @phpstan-type WhatsappSyncGetResponseShape = array{
 *   sync: WhatsAppSyncStatus|WhatsAppSyncStatusShape
 * }
 */
final class WhatsappSyncGetResponse implements BaseModel
{
    /** @use SdkModel<WhatsappSyncGetResponseShape> */
    use SdkModel;

    /**
     * WhatsApp coexistence sync status.
     */
    #[Required]
    public WhatsAppSyncStatus $sync;

    /**
     * `new WhatsappSyncGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WhatsappSyncGetResponse::with(sync: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WhatsappSyncGetResponse)->withSync(...)
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
    public static function with(WhatsAppSyncStatus|array $sync): self
    {
        $self = new self;

        $self['sync'] = $sync;

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
