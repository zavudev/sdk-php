<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\FunctionCreateParams;
use Zavudev\Functions\FunctionCreateParams\MemoryMB;
use Zavudev\Functions\FunctionCreateParams\Runtime;
use Zavudev\Functions\FunctionDeleteResponse;
use Zavudev\Functions\FunctionDeployParams;
use Zavudev\Functions\FunctionDeployResponse;
use Zavudev\Functions\FunctionGetDeploymentResponse;
use Zavudev\Functions\FunctionGetResponse;
use Zavudev\Functions\FunctionNewResponse;
use Zavudev\Functions\FunctionTailLogsParams;
use Zavudev\Functions\FunctionTailLogsResponse;
use Zavudev\Functions\FunctionUpdateParams;
use Zavudev\Functions\FunctionUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\FunctionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class FunctionsRawService implements FunctionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new Zavu Function. The function starts in `draft` status. A dedicated API key is auto-provisioned and injected as the `ZAVU_API_KEY` secret so the function can call back into the Zavu API without manual setup.
     *
     * Provide `sourceCode` to seed the draft. Call `POST /v1/functions/{functionId}/deploy` afterwards to publish.
     *
     * @param array{
     *   name: string,
     *   slug: string,
     *   dependencies?: array<string,string>,
     *   description?: string,
     *   httpEnabled?: bool,
     *   memoryMB?: MemoryMB|value-of<MemoryMB>,
     *   runtime?: Runtime|value-of<Runtime>,
     *   sourceCode?: string,
     *   timeoutSec?: int,
     * }|FunctionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|FunctionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FunctionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/functions',
            body: (object) $parsed,
            options: $options,
            convert: FunctionNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get function
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionGetResponse>
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
            path: ['v1/functions/%1$s', $functionID],
            options: $requestOptions,
            convert: FunctionGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update the draft source code and/or dependency map without triggering a build. Visible in the dashboard immediately, but the live (deployed) function does not change until `POST /v1/functions/{functionId}/deploy` runs.
     *
     * @param string $functionID zavu Function ID
     * @param array{
     *   dependencies?: array<string,string>, sourceCode?: string
     * }|FunctionUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $functionID,
        array|FunctionUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FunctionUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/functions/%1$s', $functionID],
            body: (object) $parsed,
            options: $options,
            convert: FunctionUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Permanently delete a function and cascade: triggers, secrets, deployment history, managed agents+tools, and revoke the auto-provisioned API key. The AWS Lambda + log group are torn down asynchronously.
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/functions/%1$s', $functionID],
            options: $requestOptions,
            convert: FunctionDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Publish the function. If `sourceCode` or `dependencies` are provided in the body, they replace the current draft before deployment. Returns immediately with a deployment ID — poll `GET /v1/functions/deployments/{deploymentId}` until status is `active` or `failed`.
     *
     * @param string $functionID zavu Function ID
     * @param array{
     *   dependencies?: array<string,string>, sourceCode?: string
     * }|FunctionDeployParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionDeployResponse>
     *
     * @throws APIException
     */
    public function deploy(
        string $functionID,
        array|FunctionDeployParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FunctionDeployParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/functions/%1$s/deploy', $functionID],
            body: (object) $parsed,
            options: $options,
            convert: FunctionDeployResponse::class,
        );
    }

    /**
     * @api
     *
     * Fetch a deployment to poll its status during a deploy.
     *
     * @param string $deploymentID function deployment ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionGetDeploymentResponse>
     *
     * @throws APIException
     */
    public function getDeployment(
        string $deploymentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/functions/deployments/%1$s', $deploymentID],
            options: $requestOptions,
            convert: FunctionGetDeploymentResponse::class,
        );
    }

    /**
     * @api
     *
     * Fetch invocation logs for a function. Logs are paginated via `nextToken`. Pass `startTime` / `endTime` (Unix epoch milliseconds) to bound the window, or `filterPattern` to filter messages.
     *
     * @param string $functionID zavu Function ID
     * @param array{
     *   endTime?: int,
     *   filterPattern?: string,
     *   limit?: int,
     *   nextToken?: string,
     *   startTime?: int,
     * }|FunctionTailLogsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionTailLogsResponse>
     *
     * @throws APIException
     */
    public function tailLogs(
        string $functionID,
        array|FunctionTailLogsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FunctionTailLogsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/functions/%1$s/logs', $functionID],
            query: $parsed,
            options: $options,
            convert: FunctionTailLogsResponse::class,
        );
    }
}
