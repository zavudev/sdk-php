<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\EmailDomains\EmailDomainCreateParams;
use Zavudev\EmailDomains\EmailDomainGetResponse;
use Zavudev\EmailDomains\EmailDomainListResponse;
use Zavudev\EmailDomains\EmailDomainNewResponse;
use Zavudev\EmailDomains\EmailDomainVerifyResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface EmailDomainsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|EmailDomainCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EmailDomainNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|EmailDomainCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EmailDomainListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
