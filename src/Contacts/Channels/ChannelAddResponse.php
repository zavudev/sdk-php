<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Channels;

use Zavudev\Contacts\ContactChannel;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContactChannelShape from \Zavudev\Contacts\ContactChannel
 *
 * @phpstan-type ChannelAddResponseShape = array{
 *   channel: ContactChannel|ContactChannelShape
 * }
 */
final class ChannelAddResponse implements BaseModel
{
    /** @use SdkModel<ChannelAddResponseShape> */
    use SdkModel;

    /**
     * A communication channel for a contact.
     */
    #[Required]
    public ContactChannel $channel;

    /**
     * `new ChannelAddResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChannelAddResponse::with(channel: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChannelAddResponse)->withChannel(...)
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
     * @param ContactChannel|ContactChannelShape $channel
     */
    public static function with(ContactChannel|array $channel): self
    {
        $self = new self;

        $self['channel'] = $channel;

        return $self;
    }

    /**
     * A communication channel for a contact.
     *
     * @param ContactChannel|ContactChannelShape $channel
     */
    public function withChannel(ContactChannel|array $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }
}
