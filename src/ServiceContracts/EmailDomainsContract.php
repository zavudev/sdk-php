<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\EmailDomains\EmailDomainGetResponse;
use Zavudev\EmailDomains\EmailDomainListResponse;
use Zavudev\EmailDomains\EmailDomainNewResponse;
use Zavudev\EmailDomains\EmailDomainVerifyResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface EmailDomainsContract
{
    /**
     * @api
     *
     * @param string $domain Bare domain, e.g. example.com.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $domain,
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainGetResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainListResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function verify(
        string $domainID,
        RequestOptions|array|null $requestOptions = null
    ): EmailDomainVerifyResponse;
}
