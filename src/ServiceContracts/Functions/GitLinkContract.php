<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Functions;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\GitLink\GitLinkDeployNowResponse;
use Zavudev\Functions\GitLink\GitLinkGetResponse;
use Zavudev\Functions\GitLink\GitLinkLinkResponse;
use Zavudev\Functions\GitLink\GitLinkUpdateResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface GitLinkContract
{
    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): GitLinkGetResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $functionID,
        ?bool $autoDeploy = null,
        ?string $branch = null,
        ?string $rootDir = null,
        RequestOptions|array|null $requestOptions = null,
    ): GitLinkUpdateResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deployNow(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): GitLinkDeployNowResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param string $rootDir subdirectory holding the project, for monorepos
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function link(
        string $functionID,
        string $owner,
        string $repo,
        bool $autoDeploy = true,
        string $branch = 'main',
        ?string $rootDir = null,
        RequestOptions|array|null $requestOptions = null,
    ): GitLinkLinkResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unlink(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
