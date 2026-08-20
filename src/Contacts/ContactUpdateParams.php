<?php

declare(strict_types=1);

namespace Zavudev\Contacts;

use Zavudev\Contacts\ContactUpdateParams\DefaultChannel;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update contact.
 *
 * @see Zavudev\Services\ContactsService::update()
 *
 * @phpstan-type ContactUpdateParamsShape = array{
 *   defaultChannel?: null|DefaultChannel|value-of<DefaultChannel>,
 *   displayName?: string|null,
 *   metadata?: array<string,string>|null,
 * }
 */
final class ContactUpdateParams implements BaseModel
{
    /** @use SdkModel<ContactUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Preferred channel for this contact. Set to null to clear.
     *
     * @var value-of<DefaultChannel>|null $defaultChannel
     */
    #[Optional(enum: DefaultChannel::class, nullable: true)]
    public ?string $defaultChannel;

    /**
     * Human-readable name for this contact. Set to null to clear it and fall back to the contact's identifier. Contacts created automatically from an inbound message have no display name until you set one.
     */
    #[Optional(nullable: true)]
    public ?string $displayName;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param DefaultChannel|value-of<DefaultChannel>|null $defaultChannel
     * @param array<string,string>|null $metadata
     */
    public static function with(
        DefaultChannel|string|null $defaultChannel = null,
        ?string $displayName = null,
        ?array $metadata = null,
    ): self {
        $self = new self;

        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $metadata && $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Preferred channel for this contact. Set to null to clear.
     *
     * @param DefaultChannel|value-of<DefaultChannel>|null $defaultChannel
     */
    public function withDefaultChannel(
        DefaultChannel|string|null $defaultChannel
    ): self {
        $self = clone $this;
        $self['defaultChannel'] = $defaultChannel;

        return $self;
    }

    /**
     * Human-readable name for this contact. Set to null to clear it and fall back to the contact's identifier. Contacts created automatically from an inbound message have no display name until you set one.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

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
}
