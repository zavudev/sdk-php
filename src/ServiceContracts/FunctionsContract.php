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
     * @param string $entrypoint Which file in `files` is the entry point. Defaults to `index.ts`.
     * @param array<string,string> $files The project's source files, keyed by path relative to the project root (e.g. `index.ts`, `lib/orders.ts`). Imports between them are resolved when the function is built, so a function can be split across as many files as it needs.
     *
     * Paths must be relative and use forward slashes; `..`, `node_modules/` and `package.json` are rejected. npm packages are not uploaded here — declare them under `dependencies` and Zavu installs them. Limits: 200 files and 900,000 bytes for the whole tree.
     * @param bool $httpEnabled whether to expose a public HTTPS URL for this function
     * @param MemoryMB|value-of<MemoryMB> $memoryMB
     * @param Runtime|value-of<Runtime> $runtime runtime the function is deployed on
     * @param string $sourceCode Shortcut for a single-file function: exactly equivalent to sending `files` with one entry named after `entrypoint` (`index.ts` by default). Fully supported — use whichever fits. If both are sent, `files` wins.
     * @param int $timeoutSec Per-invocation timeout in seconds. Event and cron invocations are asynchronous, so a long timeout only bounds cost; a tool called during a live conversation holds up the reply, and a function exposed over HTTP is additionally bounded by the platform's HTTP response limit.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        string $slug,
        ?array $dependencies = null,
        ?string $description = null,
        string $entrypoint = 'index.ts',
        ?array $files = null,
        bool $httpEnabled = false,
        MemoryMB|int $memoryMB = 256,
        Runtime|string|null $runtime = null,
        ?string $sourceCode = null,
        int $timeoutSec = 30,
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
     * @param string $entrypoint Which file in `files` is the entry point. Defaults to `index.ts`.
     * @param array<string,string> $files The project's source files, keyed by path relative to the project root (e.g. `index.ts`, `lib/orders.ts`). Imports between them are resolved when the function is built, so a function can be split across as many files as it needs.
     *
     * Paths must be relative and use forward slashes; `..`, `node_modules/` and `package.json` are rejected. npm packages are not uploaded here — declare them under `dependencies` and Zavu installs them. Limits: 200 files and 900,000 bytes for the whole tree.
     * @param bool $httpEnabled Expose the function on its public HTTPS URL, or take it down. Applies to the already-deployed function without redeploying; the URL is returned as `publicUrl`.
     * @param string $sourceCode Shortcut for a single-file function: exactly equivalent to sending `files` with one entry named after `entrypoint` (`index.ts` by default). Fully supported — use whichever fits. If both are sent, `files` wins.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $functionID,
        ?array $dependencies = null,
        string $entrypoint = 'index.ts',
        ?array $files = null,
        ?bool $httpEnabled = null,
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
     * @param string $entrypoint Which file in `files` is the entry point. Defaults to `index.ts`.
     * @param array<string,string> $files The project's source files, keyed by path relative to the project root (e.g. `index.ts`, `lib/orders.ts`). Imports between them are resolved when the function is built, so a function can be split across as many files as it needs.
     *
     * Paths must be relative and use forward slashes; `..`, `node_modules/` and `package.json` are rejected. npm packages are not uploaded here — declare them under `dependencies` and Zavu installs them. Limits: 200 files and 900,000 bytes for the whole tree.
     * @param string $sourceCode Shortcut for a single-file function: exactly equivalent to sending `files` with one entry named after `entrypoint` (`index.ts` by default). Fully supported — use whichever fits. If both are sent, `files` wins.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deploy(
        string $functionID,
        ?array $dependencies = null,
        string $entrypoint = 'index.ts',
        ?array $files = null,
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
