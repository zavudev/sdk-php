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
        ?array $metadata = null
    ): self {
        $self = new self;

        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
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
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }
}
