<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Remove a contact from a broadcast in draft status.
 *
 * @see Zavudev\Services\Broadcasts\ContactsService::remove()
 *
 * @phpstan-type ContactRemoveParamsShape = array{broadcastID: string}
 */
final class ContactRemoveParams implements BaseModel
{
    /** @use SdkModel<ContactRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $broadcastID;

    /**
     * `new ContactRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactRemoveParams::with(broadcastID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactRemoveParams)->withBroadcastID(...)
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
    public static function with(string $broadcastID): self
    {
        $self = new self;

        $self['broadcastID'] = $broadcastID;

        return $self;
    }

    public function withBroadcastID(string $broadcastID): self
    {
        $self = clone $this;
        $self['broadcastID'] = $broadcastID;

        return $self;
    }
}
