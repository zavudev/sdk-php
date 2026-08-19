<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\EmailDomains\EmailDomainVerifyResponse\Domain;

/**
 * @phpstan-import-type DomainShape from \Zavudev\EmailDomains\EmailDomainVerifyResponse\Domain
 *
 * @phpstan-type EmailDomainVerifyResponseShape = array{domain: Domain|DomainShape}
 */
final class EmailDomainVerifyResponse implements BaseModel
{
    /** @use SdkModel<EmailDomainVerifyResponseShape> */
    use SdkModel;

    #[Required]
    public Domain $domain;

    /**
     * `new EmailDomainVerifyResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EmailDomainVerifyResponse::with(domain: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EmailDomainVerifyResponse)->withDomain(...)
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
