<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\EmailDomains\EmailDomainCreateParams;
use Zavudev\EmailDomains\EmailDomainGetResponse;
use Zavudev\EmailDomains\EmailDomainListResponse;
use Zavudev\EmailDomains\EmailDomainNewResponse;
use Zavudev\EmailDomains\EmailDomainVerifyResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\EmailDomainsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class EmailDomainsRawService implements EmailDomainsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Add a domain to send email from. Returns the DNS records to publish (DKIM CNAMEs are required; SPF, DMARC, and MAIL FROM are recommended). Publish them at your DNS provider, then verify.
     *
     * @param array{domain: string}|EmailDomainCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EmailDomainNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|EmailDomainCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EmailDomainCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/email-domains',
            body: (object) $parsed,
            options: $options,
            convert: EmailDomainNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Fetch a domain with its DNS records and current status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EmailDomainGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/email-domains/%1$s', $domainID],
            options: $requestOptions,
            convert: EmailDomainGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List email domains
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EmailDomainListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/email-domains',
            options: $requestOptions,
            convert: EmailDomainListResponse::class,
        );
    }

    /**
     * @api
     *
     * Remove an email domain
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/email-domains/%1$s', $domainID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Re-check the domain's published DNS records and refresh its status.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EmailDomainVerifyResponse>
     *
     * @throws APIException
     */
    public function verify(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/email-domains/%1$s/verify', $domainID],
            options: $requestOptions,
            convert: EmailDomainVerifyResponse::class,
        );
    }
}
