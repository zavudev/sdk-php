<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Functions\FunctionCreateParams\MemoryMB;
use Zavudev\Functions\FunctionCreateParams\Runtime;
use Zavudev\Functions\FunctionDeleteResponse;
use Zavudev\Functions\FunctionDeployResponse;
use Zavudev\Functions\FunctionGetDeploymentResponse;
use Zavudev\Functions\FunctionGetResponse;
use Zavudev\Functions\FunctionNewResponse;
use Zavudev\Functions\FunctionTailLogsResponse;
use Zavudev\Functions\FunctionUpdateResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\FunctionsContract;
use Zavudev\Services\Functions\SecretsService;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class FunctionsService implements FunctionsContract
{
    /**
     * @api
     */
    public FunctionsRawService $raw;

    /**
     * @api
     */
    public SecretsService $secrets;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FunctionsRawService($client);
        $this->secrets = new SecretsService($client);
    }

    /**
     * @api
     *
     * Create a new Zavu Function. The function starts in `draft` status. A dedicated API key is auto-provisioned and injected as the `ZAVU_API_KEY` secret so the function can call back into the Zavu API without manual setup.
     *
     * Provide `sourceCode` to seed the draft. Call `POST /v1/functions/{functionId}/deploy` afterwards to publish.
     *
     * @param string $slug URL-safe identifier (lowercase, digits, hyphens). Must be unique per project.
     * @param array<string,string> $dependencies npm dependencies. Keys are package names, values are semver ranges.
     * @param bool $httpEnabled whether to expose a public HTTPS URL for this function
     * @param MemoryMB|value-of<MemoryMB> $memoryMB
     * @param Runtime|value-of<Runtime> $runtime runtime the function is deployed on
     * @param string $sourceCode typeScript source code for the function entry point (max ~900KB)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        string $slug,
        ?array $dependencies = null,
        ?string $description = null,
        bool $httpEnabled = false,
        MemoryMB|int $memoryMB = 256,
        Runtime|string|null $runtime = null,
        ?string $sourceCode = null,
        int $timeoutSec = 10,
        RequestOptions|array|null $requestOptions = null,
    ): FunctionNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'slug' => $slug,
                'dependencies' => $dependencies,
                'description' => $description,
                'httpEnabled' => $httpEnabled,
                'memoryMB' => $memoryMB,
                'runtime' => $runtime,
                'sourceCode' => $sourceCode,
                'timeoutSec' => $timeoutSec,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get function
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): FunctionGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($functionID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update the draft source code and/or dependency map without triggering a build. Visible in the dashboard immediately, but the live (deployed) function does not change until `POST /v1/functions/{functionId}/deploy` runs.
     *
     * @param string $functionID zavu Function ID
     * @param array<string,string> $dependencies new dependency map (replaces existing dependencies)
     * @param string $sourceCode new source code to publish (replaces the draft)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $functionID,
        ?array $dependencies = null,
        ?string $sourceCode = null,
        RequestOptions|array|null $requestOptions = null,
    ): FunctionUpdateResponse {
        $params = Util::removeNulls(
            ['dependencies' => $dependencies, 'sourceCode' => $sourceCode]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($functionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Permanently delete a function and cascade: triggers, secrets, deployment history, managed agents+tools, and revoke the auto-provisioned API key. The AWS Lambda + log group are torn down asynchronously.
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): FunctionDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($functionID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Publish the function. If `sourceCode` or `dependencies` are provided in the body, they replace the current draft before deployment. Returns immediately with a deployment ID — poll `GET /v1/functions/deployments/{deploymentId}` until status is `active` or `failed`.
     *
     * @param string $functionID zavu Function ID
     * @param array<string,string> $dependencies new dependency map (replaces existing dependencies)
     * @param string $sourceCode new source code to publish (replaces the draft)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deploy(
        string $functionID,
        ?array $dependencies = null,
        ?string $sourceCode = null,
        RequestOptions|array|null $requestOptions = null,
    ): FunctionDeployResponse {
        $params = Util::removeNulls(
            ['dependencies' => $dependencies, 'sourceCode' => $sourceCode]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deploy($functionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Fetch a deployment to poll its status during a deploy.
     *
     * @param string $deploymentID function deployment ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getDeployment(
        string $deploymentID,
        RequestOptions|array|null $requestOptions = null
    ): FunctionGetDeploymentResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getDeployment($deploymentID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Fetch invocation logs for a function. Logs are paginated via `nextToken`. Pass `startTime` / `endTime` (Unix epoch milliseconds) to bound the window, or `filterPattern` to filter messages.
     *
     * @param string $functionID zavu Function ID
     * @param int $endTime end of the log window in Unix epoch milliseconds
     * @param int $startTime start of the log window in Unix epoch milliseconds
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function tailLogs(
        string $functionID,
        ?int $endTime = null,
        ?string $filterPattern = null,
        int $limit = 100,
        ?string $nextToken = null,
        ?int $startTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): FunctionTailLogsResponse {
        $params = Util::removeNulls(
            [
                'endTime' => $endTime,
                'filterPattern' => $filterPattern,
                'limit' => $limit,
                'nextToken' => $nextToken,
                'startTime' => $startTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->tailLogs($functionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
