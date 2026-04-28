<?php

declare(strict_types=1);

namespace Zavudev\Contacts;

use Zavudev\Contacts\ContactCreateParams\Channel1 as Channel;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a new contact with one or more communication channels.
 *
 * @see Zavudev\Services\ContactsService::create()
 *
 * @phpstan-import-type Channel1Shape from \Zavudev\Contacts\ContactCreateParams\Channel1
 *
 * @phpstan-type ContactCreateParamsShape = array{
 *   channels: list<Channel|Channel1Shape>,
 *   displayName?: string|null,
 *   metadata?: array<string,string>|null,
 * }
 */
final class ContactCreateParams implements BaseModel
{
    /** @use SdkModel<ContactCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Communication channels for the contact.
     *
     * @var list<Channel> $channels
     */
    #[Required(list: Channel::class)]
    public array $channels;

    /**
     * Display name for the contact.
     */
    #[Optional]
    public ?string $displayName;

    /**
     * Arbitrary metadata to associate with the contact.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * `new ContactCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactCreateParams::with(channels: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactCreateParams)->withChannels(...)
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
     * @param list<Channel|Channel1Shape> $channels
     * @param array<string,string>|null $metadata
     */
    public static function with(
        array $channels,
        ?string $displayName = null,
        ?array $metadata = null
    ): self {
        $self = new self;

        $self['channels'] = $channels;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $metadata && $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Communication channels for the contact.
     *
     * @param list<Channel|Channel1Shape> $channels
     */
    public function withChannels(array $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    /**
     * Display name for the contact.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Arbitrary metadata to associate with the contact.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }
}
