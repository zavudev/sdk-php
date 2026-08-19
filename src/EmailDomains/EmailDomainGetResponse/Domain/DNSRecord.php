<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains\EmailDomainGetResponse\Domain;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\EmailDomains\EmailDomainGetResponse\Domain\DNSRecord\Purpose;

/**
 * @phpstan-type DNSRecordShape = array{
 *   name: string,
 *   purpose: Purpose|value-of<Purpose>,
 *   required: bool,
 *   type: string,
 *   value: string,
 *   priority?: int|null,
 * }
 */
final class DNSRecord implements BaseModel
{
    /** @use SdkModel<DNSRecordShape> */
    use SdkModel;

    /**
     * Record host/name to create.
     */
    #[Required]
    public string $name;

    /**
     * What the record is for.
     *
     * @var value-of<Purpose> $purpose
     */
    #[Required(enum: Purpose::class)]
    public string $purpose;

    /**
     * Whether the record is required to verify + send (DKIM) or recommended for deliverability.
     */
    #[Required]
    public bool $required;

    /**
     * DNS record type.
     */
    #[Required]
    public string $type;

    /**
     * Record value.
     */
    #[Required]
    public string $value;

    /**
     * Priority (MX records only).
     */
    #[Optional]
    public ?int $priority;

    /**
     * `new DNSRecord()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DNSRecord::with(name: ..., purpose: ..., required: ..., type: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DNSRecord)
     *   ->withName(...)
     *   ->withPurpose(...)
     *   ->withRequired(...)
     *   ->withType(...)
     *   ->withValue(...)
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
     * @param Purpose|value-of<Purpose> $purpose
     */
    public static function with(
        string $name,
        Purpose|string $purpose,
        bool $required,
        string $type,
        string $value,
        ?int $priority = null,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['purpose'] = $purpose;
        $self['required'] = $required;
        $self['type'] = $type;
        $self['value'] = $value;

        null !== $priority && $self['priority'] = $priority;

        return $self;
    }

    /**
     * Record host/name to create.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * What the record is for.
     *
     * @param Purpose|value-of<Purpose> $purpose
     */
    public function withPurpose(Purpose|string $purpose): self
    {
        $self = clone $this;
        $self['purpose'] = $purpose;

        return $self;
    }

    /**
     * Whether the record is required to verify + send (DKIM) or recommended for deliverability.
     */
    public function withRequired(bool $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }

    /**
     * DNS record type.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Record value.
     */
    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }

    /**
     * Priority (MX records only).
     */
    public function withPriority(int $priority): self
    {
        $self = clone $this;
        $self['priority'] = $priority;

        return $self;
    }
}
