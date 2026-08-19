<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\EmailDomains\EmailDomainGetResponse\Domain;

/**
 * @phpstan-import-type DomainShape from \Zavudev\EmailDomains\EmailDomainGetResponse\Domain
 *
 * @phpstan-type EmailDomainGetResponseShape = array{domain: Domain|DomainShape}
 */
final class EmailDomainGetResponse implements BaseModel
{
    /** @use SdkModel<EmailDomainGetResponseShape> */
    use SdkModel;

    #[Required]
    public Domain $domain;

    /**
     * `new EmailDomainGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EmailDomainGetResponse::with(domain: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EmailDomainGetResponse)->withDomain(...)
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
     * @param Domain|DomainShape $domain
     */
    public static function with(Domain|array $domain): self
    {
        $self = new self;

        $self['domain'] = $domain;

        return $self;
    }

    /**
     * @param Domain|DomainShape $domain
     */
    public function withDomain(Domain|array $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }
}
