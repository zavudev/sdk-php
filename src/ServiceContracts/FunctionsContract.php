<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
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

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface FunctionsContract
{
    /**
     * @api
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
    ): FunctionNewResponse;

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
    ): FunctionGetResponse;

    /**
     * @api
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
    ): FunctionUpdateResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): FunctionDeleteResponse;

    /**
     * @api
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
    ): FunctionDeployResponse;

    /**
     * @api
     *
     * @param string $deploymentID function deployment ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getDeployment(
        string $deploymentID,
        RequestOptions|array|null $requestOptions = null
    ): FunctionGetDeploymentResponse;

    /**
     * @api
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
    ): FunctionTailLogsResponse;
}
