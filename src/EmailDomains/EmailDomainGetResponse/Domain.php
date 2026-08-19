<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains\EmailDomainGetResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\EmailDomains\EmailDomainGetResponse\Domain\DNSRecord;

/**
 * @phpstan-import-type DNSRecordShape from \Zavudev\EmailDomains\EmailDomainGetResponse\Domain\DNSRecord
 *
 * @phpstan-type DomainShape = array{
 *   id: string,
 *   dkimStatus: string,
 *   domain: string,
 *   status: string,
 *   dnsRecords?: list<DNSRecord|DNSRecordShape>|null,
 * }
 */
final class Domain implements BaseModel
{
    /** @use SdkModel<DomainShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $dkimStatus;

    #[Required]
    public string $domain;

    /**
     * Overall verification status.
     */
    #[Required]
    public string $status;

    /**
     * DNS records to publish. Present when fetching a single domain or after adding one.
     *
     * @var list<DNSRecord>|null $dnsRecords
     */
    #[Optional(list: DNSRecord::class)]
    public ?array $dnsRecords;

    /**
     * `new Domain()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Domain::with(id: ..., dkimStatus: ..., domain: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Domain)->withID(...)->withDkimStatus(...)->withDomain(...)->withStatus(...)
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
     * @param list<DNSRecord|DNSRecordShape>|null $dnsRecords
     */
    public static function with(
        string $id,
        string $dkimStatus,
        string $domain,
        string $status,
        ?array $dnsRecords = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['dkimStatus'] = $dkimStatus;
        $self['domain'] = $domain;
        $self['status'] = $status;

        null !== $dnsRecords && $self['dnsRecords'] = $dnsRecords;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withDkimStatus(string $dkimStatus): self
    {
        $self = clone $this;
        $self['dkimStatus'] = $dkimStatus;

        return $self;
    }

    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    /**
     * Overall verification status.
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * DNS records to publish. Present when fetching a single domain or after adding one.
     *
     * @param list<DNSRecord|DNSRecordShape> $dnsRecords
     */
    public function withDNSRecords(array $dnsRecords): self
    {
        $self = clone $this;
        $self['dnsRecords'] = $dnsRecords;

        return $self;
    }
}
