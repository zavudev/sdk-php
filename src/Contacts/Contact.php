<?php

declare(strict_types=1);

namespace Zavudev\Contacts;

use Zavudev\Contacts\Contact\DefaultChannel;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ContactShape = array{
 *   id: string,
 *   phoneNumber: string,
 *   availableChannels?: list<string>|null,
 *   countryCode?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   defaultChannel?: null|DefaultChannel|value-of<DefaultChannel>,
 *   metadata?: array<string,string>|null,
 *   profileName?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   verified?: bool|null,
 * }
 */
final class Contact implements BaseModel
{
    /** @use SdkModel<ContactShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * E.164 phone number.
     */
    #[Required]
    public string $phoneNumber;

    /**
     * List of available messaging channels for this contact.
     *
     * @var list<string>|null $availableChannels
     */
    #[Optional(list: 'string')]
    public ?array $availableChannels;

    #[Optional]
    public ?string $countryCode;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Preferred channel for this contact.
     *
     * @var value-of<DefaultChannel>|null $defaultChannel
     */
    #[Optional(enum: DefaultChannel::class)]
    public ?string $defaultChannel;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Contact's WhatsApp profile name. Only available for WhatsApp contacts.
     */
    #[Optional(nullable: true)]
    public ?string $profileName;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Whether this contact has been verified.
     */
    #[Optional]
    public ?bool $verified;

    /**
     * `new Contact()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Contact::with(id: ..., phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Contact)->withID(...)->withPhoneNumber(...)
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
     * @param list<string>|null $availableChannels
     * @param DefaultChannel|value-of<DefaultChannel>|null $defaultChannel
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $id,
        string $phoneNumber,
        ?array $availableChannels = null,
        ?string $countryCode = null,
        ?\DateTimeInterface $createdAt = null,
        DefaultChannel|string|null $defaultChannel = null,
        ?array $metadata = null,
        ?string $profileName = null,
        ?\DateTimeInterface $updatedAt = null,
        ?bool $verified = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['phoneNumber'] = $phoneNumber;

        null !== $availableChannels && $self['availableChannels'] = $availableChannels;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $profileName && $self['profileName'] = $profileName;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $verified && $self['verified'] = $verified;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * E.164 phone number.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * List of available messaging channels for this contact.
     *
     * @param list<string> $availableChannels
     */
    public function withAvailableChannels(array $availableChannels): self
    {
        $self = clone $this;
        $self['availableChannels'] = $availableChannels;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Preferred channel for this contact.
     *
     * @param DefaultChannel|value-of<DefaultChannel> $defaultChannel
     */
    public function withDefaultChannel(
        DefaultChannel|string $defaultChannel
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

    /**
     * Contact's WhatsApp profile name. Only available for WhatsApp contacts.
     */
    public function withProfileName(?string $profileName): self
    {
        $self = clone $this;
        $self['profileName'] = $profileName;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Whether this contact has been verified.
     */
    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }
}
