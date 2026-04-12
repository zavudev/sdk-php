<?php

declare(strict_types=1);

namespace Zavudev\Contacts;

use Zavudev\Contacts\Contact\DefaultChannel;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContactChannelShape from \Zavudev\Contacts\ContactChannel
 *
 * @phpstan-type ContactShape = array{
 *   id: string,
 *   availableChannels: list<string>,
 *   createdAt: \DateTimeInterface,
 *   metadata: array<string,string>,
 *   verified: bool,
 *   channels?: list<ContactChannel|ContactChannelShape>|null,
 *   countryCode?: string|null,
 *   defaultChannel?: null|DefaultChannel|value-of<DefaultChannel>,
 *   displayName?: string|null,
 *   phoneNumber?: string|null,
 *   primaryEmail?: string|null,
 *   primaryPhone?: string|null,
 *   profileName?: string|null,
 *   suggestedMergeWith?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Contact implements BaseModel
{
    /** @use SdkModel<ContactShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * List of available messaging channels for this contact.
     *
     * @var list<string> $availableChannels
     */
    #[Required(list: 'string')]
    public array $availableChannels;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var array<string,string> $metadata */
    #[Required(map: 'string')]
    public array $metadata;

    /**
     * Whether this contact has been verified.
     */
    #[Required]
    public bool $verified;

    /**
     * All communication channels for this contact.
     *
     * @var list<ContactChannel>|null $channels
     */
    #[Optional(list: ContactChannel::class)]
    public ?array $channels;

    #[Optional]
    public ?string $countryCode;

    /**
     * Preferred channel for this contact.
     *
     * @var value-of<DefaultChannel>|null $defaultChannel
     */
    #[Optional(enum: DefaultChannel::class)]
    public ?string $defaultChannel;

    /**
     * Display name for the contact.
     */
    #[Optional]
    public ?string $displayName;

    /**
     * DEPRECATED: Use primaryPhone instead. Primary phone number in E.164 format.
     */
    #[Optional]
    public ?string $phoneNumber;

    /**
     * Primary email address.
     */
    #[Optional]
    public ?string $primaryEmail;

    /**
     * Primary phone number in E.164 format.
     */
    #[Optional]
    public ?string $primaryPhone;

    /**
     * Contact's WhatsApp profile name. Only available for WhatsApp contacts.
     */
    #[Optional(nullable: true)]
    public ?string $profileName;

    /**
     * ID of a contact suggested for merging.
     */
    #[Optional]
    public ?string $suggestedMergeWith;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new Contact()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Contact::with(
     *   id: ..., availableChannels: ..., createdAt: ..., metadata: ..., verified: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Contact)
     *   ->withID(...)
     *   ->withAvailableChannels(...)
     *   ->withCreatedAt(...)
     *   ->withMetadata(...)
     *   ->withVerified(...)
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
     * @param list<string> $availableChannels
     * @param array<string,string> $metadata
     * @param list<ContactChannel|ContactChannelShape>|null $channels
     * @param DefaultChannel|value-of<DefaultChannel>|null $defaultChannel
     */
    public static function with(
        string $id,
        array $availableChannels,
        \DateTimeInterface $createdAt,
        array $metadata,
        bool $verified,
        ?array $channels = null,
        ?string $countryCode = null,
        DefaultChannel|string|null $defaultChannel = null,
        ?string $displayName = null,
        ?string $phoneNumber = null,
        ?string $primaryEmail = null,
        ?string $primaryPhone = null,
        ?string $profileName = null,
        ?string $suggestedMergeWith = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['availableChannels'] = $availableChannels;
        $self['createdAt'] = $createdAt;
        $self['metadata'] = $metadata;
        $self['verified'] = $verified;

        null !== $channels && $self['channels'] = $channels;
        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $defaultChannel && $self['defaultChannel'] = $defaultChannel;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $primaryEmail && $self['primaryEmail'] = $primaryEmail;
        null !== $primaryPhone && $self['primaryPhone'] = $primaryPhone;
        null !== $profileName && $self['profileName'] = $profileName;
        null !== $suggestedMergeWith && $self['suggestedMergeWith'] = $suggestedMergeWith;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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
     * Whether this contact has been verified.
     */
    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }

    /**
     * All communication channels for this contact.
     *
     * @param list<ContactChannel|ContactChannelShape> $channels
     */
    public function withChannels(array $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

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
     * Display name for the contact.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * DEPRECATED: Use primaryPhone instead. Primary phone number in E.164 format.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * Primary email address.
     */
    public function withPrimaryEmail(string $primaryEmail): self
    {
        $self = clone $this;
        $self['primaryEmail'] = $primaryEmail;

        return $self;
    }

    /**
     * Primary phone number in E.164 format.
     */
    public function withPrimaryPhone(string $primaryPhone): self
    {
        $self = clone $this;
        $self['primaryPhone'] = $primaryPhone;

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

    /**
     * ID of a contact suggested for merging.
     */
    public function withSuggestedMergeWith(string $suggestedMergeWith): self
    {
        $self = clone $this;
        $self['suggestedMergeWith'] = $suggestedMergeWith;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
