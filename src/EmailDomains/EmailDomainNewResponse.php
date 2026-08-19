<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\EmailDomains\EmailDomainNewResponse\Domain;

/**
 * @phpstan-import-type DomainShape from \Zavudev\EmailDomains\EmailDomainNewResponse\Domain
 *
 * @phpstan-type EmailDomainNewResponseShape = array{domain: Domain|DomainShape}
 */
final class EmailDomainNewResponse implements BaseModel
{
    /** @use SdkModel<EmailDomainNewResponseShape> */
    use SdkModel;

    #[Required]
    public Domain $domain;

    /**
     * `new EmailDomainNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EmailDomainNewResponse::with(domain: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EmailDomainNewResponse)->withDomain(...)
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
