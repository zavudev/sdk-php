<?php

declare(strict_types=1);

namespace Zavudev\Services\Functions;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\GitLink\GitLinkDeployNowResponse;
use Zavudev\Functions\GitLink\GitLinkGetResponse;
use Zavudev\Functions\GitLink\GitLinkLinkParams;
use Zavudev\Functions\GitLink\GitLinkLinkResponse;
use Zavudev\Functions\GitLink\GitLinkUpdateParams;
use Zavudev\Functions\GitLink\GitLinkUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Functions\GitLinkRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class GitLinkRawService implements GitLinkRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * The link and its last deploy. Never returns the webhook secret.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/functions/%1$s/git-link', $functionID],
            options: $requestOptions,
            convert: GitLinkGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Change the branch, the root directory, or whether pushes deploy. Pass at least one field. `rootDir: null` clears the subdirectory.
     *
     * @param string $functionID zavu Function ID
     * @param array{
     *   autoDeploy?: bool, branch?: string, rootDir?: string|null
     * }|GitLinkUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = GitLinkUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/functions/%1$s/git-link', $functionID],
            body: (object) $parsed,
            options: $options,
            convert: GitLinkUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Fetch the linked branch and deploy it without waiting for a push. Returns immediately; follow the outcome with `GET /v1/functions/{functionId}/git-link`, whose `lastStatus` and `lastError` describe the run.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/functions/%1$s/git-link/deploy', $functionID],
            options: $requestOptions,
            convert: GitLinkDeployNowResponse::class,
        );
    }

    /**
     * @api
     *
     * Bind a repository to this function so every push to `branch` deploys it. A function holds at most one link; linking again returns 400.
     *
     * **The server decides how the link authenticates.** If the project has the Zavu GitHub App installed, the link uses that installation: private repositories work and there is nothing to configure in the repository. Otherwise it falls back to a manual link and the response carries a `webhookSecret` you add to the repository yourself. `connection` says which one you got.
     *
     * The repository is not checked against GitHub here, because it cannot be: an owner/repo that does not exist, or that the installation cannot see, is accepted and fails on the first deploy with a fetch error.
     *
     * @param string $functionID zavu Function ID
     * @param array{
     *   owner: string,
     *   repo: string,
     *   autoDeploy?: bool,
     *   branch?: string,
     *   rootDir?: string,
     * }|GitLinkLinkParams $params
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
    ): BaseResponse {
        [$parsed, $options] = GitLinkLinkParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/functions/%1$s/git-link', $functionID],
            body: (object) $parsed,
            options: $options,
            convert: GitLinkLinkResponse::class,
        );
    }

    /**
     * @api
     *
     * Remove the link. The function and its deployments stay. A manual webhook left in the repository stops being accepted, so remove it there too.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/functions/%1$s/git-link', $functionID],
            options: $requestOptions,
            convert: null,
        );
    }
}
