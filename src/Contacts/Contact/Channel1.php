<?php

declare(strict_types=1);

namespace Zavudev\Contacts\Contact;

use Zavudev\Contacts\Contact\Channel1\Channel;
use Zavudev\Contacts\Contact\Channel1\Metrics;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A communication channel for a contact.
 *
 * @phpstan-import-type MetricsShape from \Zavudev\Contacts\Contact\Channel1\Metrics
 *
 * @phpstan-type Channel1Shape = array{
 *   id: string,
 *   channel: Channel|value-of<Channel>,
 *   createdAt: \DateTimeInterface,
 *   identifier: string,
 *   isPrimary: bool,
 *   verified: bool,
 *   countryCode?: string|null,
 *   label?: string|null,
 *   lastInboundAt?: \DateTimeInterface|null,
 *   metadata?: array<string,string>|null,
 *   metrics?: null|Metrics|MetricsShape,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class Channel1 implements BaseModel
{
    /** @use SdkModel<Channel1Shape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Channel type.
     *
     * @var value-of<Channel> $channel
     */
    #[Required(enum: Channel::class)]
    public string $channel;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Channel identifier (phone number or email address).
     */
    #[Required]
    public string $identifier;

    /**
     * Whether this is the primary channel for its type.
     */
    #[Required]
    public bool $isPrimary;

    /**
     * Whether this channel has been verified.
     */
    #[Required]
    public bool $verified;

    /**
     * ISO country code for phone numbers.
     */
    #[Optional]
    public ?string $countryCode;

    /**
     * Optional label for the channel.
     */
    #[Optional]
    public ?string $label;

    /**
     * Last time a message was received on this channel.
     */
    #[Optional]
    public ?\DateTimeInterface $lastInboundAt;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Delivery metrics for this channel.
     */
    #[Optional]
    public ?Metrics $metrics;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new Channel1()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Channel1::with(
     *   id: ...,
     *   channel: ...,
     *   createdAt: ...,
     *   identifier: ...,
     *   isPrimary: ...,
     *   verified: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Channel1)
     *   ->withID(...)
     *   ->withChannel(...)
     *   ->withCreatedAt(...)
     *   ->withIdentifier(...)
     *   ->withIsPrimary(...)
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
     * @param Channel|value-of<Channel> $channel
     * @param array<string,string>|null $metadata
     * @param Metrics|MetricsShape|null $metrics
     */
    public static function with(
        string $id,
        Channel|string $channel,
        \DateTimeInterface $createdAt,
        string $identifier,
        bool $isPrimary,
        bool $verified,
        ?string $countryCode = null,
        ?string $label = null,
        ?\DateTimeInterface $lastInboundAt = null,
        ?array $metadata = null,
        Metrics|array|null $metrics = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['channel'] = $channel;
        $self['createdAt'] = $createdAt;
        $self['identifier'] = $identifier;
        $self['isPrimary'] = $isPrimary;
        $self['verified'] = $verified;

        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $label && $self['label'] = $label;
        null !== $lastInboundAt && $self['lastInboundAt'] = $lastInboundAt;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $metrics && $self['metrics'] = $metrics;
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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Channel identifier (phone number or email address).
     */
    public function withIdentifier(string $identifier): self
    {
        $self = clone $this;
        $self['identifier'] = $identifier;

        return $self;
    }

    /**
     * Whether this is the primary channel for its type.
     */
    public function withIsPrimary(bool $isPrimary): self
    {
        $self = clone $this;
        $self['isPrimary'] = $isPrimary;

        return $self;
    }

    /**
     * Whether this channel has been verified.
     */
    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

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
     * Optional label for the channel.
     */
    public function withLabel(string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }

    /**
     * Last time a message was received on this channel.
     */
    public function withLastInboundAt(\DateTimeInterface $lastInboundAt): self
    {
        $self = clone $this;
        $self['lastInboundAt'] = $lastInboundAt;

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
     * Delivery metrics for this channel.
     *
     * @param Metrics|MetricsShape $metrics
     */
    public function withMetrics(Metrics|array $metrics): self
    {
        $self = clone $this;
        $self['metrics'] = $metrics;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
