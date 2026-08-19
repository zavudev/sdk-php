<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Add a domain to send email from. Returns the DNS records to publish (DKIM CNAMEs are required; SPF, DMARC, and MAIL FROM are recommended). Publish them at your DNS provider, then verify.
 *
 * @see Zavudev\Services\EmailDomainsService::create()
 *
 * @phpstan-type EmailDomainCreateParamsShape = array{domain: string}
 */
final class EmailDomainCreateParams implements BaseModel
{
    /** @use SdkModel<EmailDomainCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Bare domain, e.g. example.com.
     */
    #[Required]
    public string $domain;

    /**
     * `new EmailDomainCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EmailDomainCreateParams::with(domain: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EmailDomainCreateParams)->withDomain(...)
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
     */
    public static function with(string $domain): self
    {
        $self = new self;

        $self['domain'] = $domain;

        return $self;
    }

    /**
     * Bare domain, e.g. example.com.
     */
    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }
}
