<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\EmailDomains\EmailDomainGetResponse;
use Zavudev\EmailDomains\EmailDomainListResponse;
use Zavudev\EmailDomains\EmailDomainNewResponse;
use Zavudev\EmailDomains\EmailDomainVerifyResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\EmailDomainsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class EmailDomainsService implements EmailDomainsContract
{
    /**
     * @api
     */
    public EmailDomainsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new EmailDomainsRawService($client);
    }

    /**
     * @api
     *
     * Add a domain to send email from. Returns the DNS records to publish (DKIM CNAMEs are required; SPF, DMARC, and MAIL FROM are recommended). Publish them at your DNS provider, then verify.
     *
     * @param string $domain Bare domain, e.g. example.com.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $domain,
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainNewResponse {
        $params = Util::removeNulls(['domain' => $domain]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Fetch a domain with its DNS records and current status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($domainID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List email domains
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove an email domain
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($domainID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Re-check the domain's published DNS records and refresh its status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function verify(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainVerifyResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->verify($domainID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
