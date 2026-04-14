<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Channels;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update a contact's channel properties.
 *
 * @see Zavudev\Services\Contacts\ChannelsService::update()
 *
 * @phpstan-type ChannelUpdateParamsShape = array{
 *   contactID: string,
 *   label?: string|null,
 *   metadata?: array<string,string>|null,
 *   verified?: bool|null,
 * }
 */
final class ChannelUpdateParams implements BaseModel
{
    /** @use SdkModel<ChannelUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $contactID;

    /**
     * Optional label for the channel. Set to null to clear.
     */
    #[Optional(nullable: true)]
    public ?string $label;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Whether the channel is verified.
     */
    #[Optional]
    public ?bool $verified;

    /**
     * `new ChannelUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChannelUpdateParams::with(contactID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChannelUpdateParams)->withContactID(...)
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
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $contactID,
        ?string $label = null,
        ?array $metadata = null,
        ?bool $verified = null,
    ): self {
        $self = new self;

        $self['contactID'] = $contactID;

        null !== $label && $self['label'] = $label;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $verified && $self['verified'] = $verified;

        return $self;
    }

    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    /**
     * Optional label for the channel. Set to null to clear.
     */
    public function withLabel(?string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }

    /**
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Whether the channel is verified.
     */
    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }
}
