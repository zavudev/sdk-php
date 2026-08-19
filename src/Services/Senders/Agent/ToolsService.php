<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\AgentTool;
use Zavudev\Senders\Agent\Tools\ToolGetResponse;
use Zavudev\Senders\Agent\Tools\ToolListTestRunsResponse;
use Zavudev\Senders\Agent\Tools\ToolNewResponse;
use Zavudev\Senders\Agent\Tools\ToolParameters;
use Zavudev\Senders\Agent\Tools\ToolTestResponse;
use Zavudev\Senders\Agent\Tools\ToolUpdateResponse;
use Zavudev\ServiceContracts\Senders\Agent\ToolsContract;
use Zavudev\Services\Senders\Agent\Tools\WebhookService;

/**
 * @phpstan-import-type ToolParametersShape from \Zavudev\Senders\Agent\Tools\ToolParameters
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ToolsService implements ToolsContract
{
    /**
     * @api
     */
    public ToolsRawService $raw;

    /**
     * @api
     */
    public WebhookService $webhook;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ToolsRawService($client);
        $this->webhook = new WebhookService($client);
    }

    /**
     * @api
     *
     * Create a new tool for an agent. Tools allow the agent to call external webhooks.
     *
     * @param ToolParameters|ToolParametersShape $parameters
     * @param string $webhookURL must be HTTPS
     * @param string $webhookSecret Signing secret for the webhook. Optional: Zavu generates one when omitted and returns it on this response only. Supply your own if you already have a secret you want reused.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $description,
        string $name,
        ToolParameters|array $parameters,
        string $webhookURL,
        bool $enabled = true,
        ?string $webhookSecret = null,
        RequestOptions|array|null $requestOptions = null,
    ): ToolNewResponse {
        $params = Util::removeNulls(
            [
                'description' => $description,
                'name' => $name,
                'parameters' => $parameters,
                'webhookURL' => $webhookURL,
                'enabled' => $enabled,
                'webhookSecret' => $webhookSecret,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a specific tool.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $toolID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): ToolGetResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($toolID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a tool.
     *
     * @param string $toolID Path param
     * @param string $senderID Path param
     * @param string $description Body param
     * @param bool $enabled Body param
     * @param string $name Body param
     * @param ToolParameters|ToolParametersShape $parameters Body param
     * @param string|null $webhookSecret Body param
     * @param string $webhookURL Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $toolID,
        string $senderID,
        ?string $description = null,
        ?bool $enabled = null,
        ?string $name = null,
        ToolParameters|array|null $parameters = null,
        ?string $webhookSecret = null,
        ?string $webhookURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): ToolUpdateResponse {
        $params = Util::removeNulls(
            [
                'senderID' => $senderID,
                'description' => $description,
                'enabled' => $enabled,
                'name' => $name,
                'parameters' => $parameters,
                'webhookSecret' => $webhookSecret,
                'webhookURL' => $webhookURL,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($toolID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tools for an agent.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<AgentTool>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        ?bool $enabled = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'enabled' => $enabled, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a tool.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $toolID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($toolID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Recent runs of this tool triggered from the test endpoint, newest first. Covers manual tests only: a tool called by an agent during a real conversation is not recorded here.
     *
     * @param string $toolID Path param
     * @param string $senderID Path param
     * @param int $limit Query param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listTestRuns(
        string $toolID,
        string $senderID,
        int $limit = 20,
        RequestOptions|array|null $requestOptions = null,
    ): ToolListTestRunsResponse {
        $params = Util::removeNulls(['senderID' => $senderID, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listTestRuns($toolID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Run a tool with the parameters you supply and return what it answered.
     *
     * The call is synchronous: the response carries the tool's status, body, and duration, so a green result is evidence the tool ran rather than evidence it was accepted. Each run is also recorded and readable afterwards via `GET /v1/senders/{senderId}/agent/tools/{toolId}/test-runs`.
     *
     * A tool that answers with an error is reported as a run with `success: false` — the endpoint itself still returns 200. This fires the tool's real webhook, so a test has whatever side effects the tool has.
     *
     * @param string $toolID Path param
     * @param string $senderID Path param
     * @param array<string,mixed> $testParams body param: Parameters to pass to the tool for testing
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $toolID,
        string $senderID,
        array $testParams,
        RequestOptions|array|null $requestOptions = null,
    ): ToolTestResponse {
        $params = Util::removeNulls(
            ['senderID' => $senderID, 'testParams' => $testParams]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->test($toolID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
