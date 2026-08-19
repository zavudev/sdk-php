<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Functions;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\GitLink\GitLinkDeployNowResponse;
use Zavudev\Functions\GitLink\GitLinkGetResponse;
use Zavudev\Functions\GitLink\GitLinkLinkParams;
use Zavudev\Functions\GitLink\GitLinkLinkResponse;
use Zavudev\Functions\GitLink\GitLinkUpdateParams;
use Zavudev\Functions\GitLink\GitLinkUpdateResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface GitLinkRawContract
{
    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GitLinkGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param array<string,mixed>|GitLinkUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GitLinkUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $functionID,
        array|GitLinkUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GitLinkDeployNowResponse>
     *
     * @throws APIException
     */
    public function deployNow(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param array<string,mixed>|GitLinkLinkParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GitLinkLinkResponse>
     *
     * @throws APIException
     */
    public function link(
        string $functionID,
        array|GitLinkLinkParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function unlink(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
