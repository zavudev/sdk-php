<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Channels;

use Zavudev\Contacts\Channels\ChannelAddParams\Channel;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Add a new communication channel to an existing contact.
 *
 * @see Zavudev\Services\Contacts\ChannelsService::add()
 *
 * @phpstan-type ChannelAddParamsShape = array{
 *   channel: Channel|value-of<Channel>,
 *   identifier: string,
 *   countryCode?: string|null,
 *   isPrimary?: bool|null,
 *   label?: string|null,
 * }
 */
final class ChannelAddParams implements BaseModel
{
    /** @use SdkModel<ChannelAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Channel type.
     *
     * @var value-of<Channel> $channel
     */
    #[Required(enum: Channel::class)]
    public string $channel;

    /**
     * Channel identifier (phone number in E.164 format or email address).
     */
    #[Required]
    public string $identifier;

    /**
     * ISO country code for phone numbers.
     */
    #[Optional]
    public ?string $countryCode;

    /**
     * Whether this should be the primary channel for its type.
     */
    #[Optional]
    public ?bool $isPrimary;

    /**
     * Optional label for the channel.
     */
    #[Optional]
    public ?string $label;

    /**
     * `new ChannelAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChannelAddParams::with(channel: ..., identifier: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChannelAddParams)->withChannel(...)->withIdentifier(...)
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
     * @param Channel|value-of<Channel> $channel
     */
    public static function with(
        Channel|string $channel,
        string $identifier,
        ?string $countryCode = null,
        ?bool $isPrimary = null,
        ?string $label = null,
    ): self {
        $self = new self;

        $self['channel'] = $channel;
        $self['identifier'] = $identifier;

        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $isPrimary && $self['isPrimary'] = $isPrimary;
        null !== $label && $self['label'] = $label;

        return $self;
    }

    /**
     * Channel type.
     *
     * @param Channel|value-of<Channel> $channel
     */
    public function withChannel(Channel|string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Channel identifier (phone number in E.164 format or email address).
     */
    public function withIdentifier(string $identifier): self
    {
        $self = clone $this;
        $self['identifier'] = $identifier;

        return $self;
    }

    /**
     * ISO country code for phone numbers.
     */
    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * Whether this should be the primary channel for its type.
     */
    public function withIsPrimary(bool $isPrimary): self
    {
        $self = clone $this;
        $self['isPrimary'] = $isPrimary;

        return $self;
    }

    /**
     * Optional label for the channel.
     */
    public function withLabel(string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }
}
