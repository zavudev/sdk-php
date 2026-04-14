<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Channels;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Remove a communication channel from a contact. Cannot remove the last channel.
 *
 * @see Zavudev\Services\Contacts\ChannelsService::remove()
 *
 * @phpstan-type ChannelRemoveParamsShape = array{contactID: string}
 */
final class ChannelRemoveParams implements BaseModel
{
    /** @use SdkModel<ChannelRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $contactID;

    /**
     * `new ChannelRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChannelRemoveParams::with(contactID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChannelRemoveParams)->withContactID(...)
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
    public static function with(string $contactID): self
    {
        $self = new self;

        $self['contactID'] = $contactID;

        return $self;
    }

    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }
}
