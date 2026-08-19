<?php

declare(strict_types=1);

namespace Zavudev\Services\Functions;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Functions\GitLink\GitLinkDeployNowResponse;
use Zavudev\Functions\GitLink\GitLinkGetResponse;
use Zavudev\Functions\GitLink\GitLinkLinkResponse;
use Zavudev\Functions\GitLink\GitLinkUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Functions\GitLinkContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class GitLinkService implements GitLinkContract
{
    /**
     * @api
     */
    public GitLinkRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new GitLinkRawService($client);
    }

    /**
     * @api
     *
     * The link and its last deploy. Never returns the webhook secret.
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): GitLinkGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($functionID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Change the branch, the root directory, or whether pushes deploy. Pass at least one field. `rootDir: null` clears the subdirectory.
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
    ): GitLinkUpdateResponse {
        $params = Util::removeNulls(
            ['autoDeploy' => $autoDeploy, 'branch' => $branch, 'rootDir' => $rootDir]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($functionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Fetch the linked branch and deploy it without waiting for a push. Returns immediately; follow the outcome with `GET /v1/functions/{functionId}/git-link`, whose `lastStatus` and `lastError` describe the run.
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deployNow(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): GitLinkDeployNowResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deployNow($functionID, requestOptions: $requestOptions);

        return $response->parse();
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
    ): GitLinkLinkResponse {
        $params = Util::removeNulls(
            [
                'owner' => $owner,
                'repo' => $repo,
                'autoDeploy' => $autoDeploy,
                'branch' => $branch,
                'rootDir' => $rootDir,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->link($functionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove the link. The function and its deployments stay. A manual webhook left in the repository stops being accepted, so remove it there too.
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unlink(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->unlink($functionID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
