<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Channels;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Set a channel as the primary channel for its type.
 *
 * @see Zavudev\Services\Contacts\ChannelsService::setPrimary()
 *
 * @phpstan-type ChannelSetPrimaryParamsShape = array{contactID: string}
 */
final class ChannelSetPrimaryParams implements BaseModel
{
    /** @use SdkModel<ChannelSetPrimaryParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $contactID;

    /**
     * `new ChannelSetPrimaryParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChannelSetPrimaryParams::with(contactID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChannelSetPrimaryParams)->withContactID(...)
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
