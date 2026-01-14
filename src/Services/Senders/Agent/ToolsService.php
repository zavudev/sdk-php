<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\AgentTool;
use Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters;
use Zavudev\Senders\Agent\Tools\ToolGetResponse;
use Zavudev\Senders\Agent\Tools\ToolNewResponse;
use Zavudev\Senders\Agent\Tools\ToolTestResponse;
use Zavudev\Senders\Agent\Tools\ToolUpdateResponse;
use Zavudev\ServiceContracts\Senders\Agent\ToolsContract;

/**
 * @phpstan-import-type ParametersShape from \Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters
 * @phpstan-import-type ParametersShape from \Zavudev\Senders\Agent\Tools\ToolUpdateParams\Parameters as ParametersShape1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ToolsService implements ToolsContract
{
    /**
     * @api
     */
    public ToolsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ToolsRawService($client);
    }

    /**
     * @api
     *
     * Create a new tool for an agent. Tools allow the agent to call external webhooks.
     *
     * @param Parameters|ParametersShape $parameters
     * @param string $webhookURL must be HTTPS
     * @param string $webhookSecret optional secret for webhook signature verification
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $description,
        string $name,
        Parameters|array $parameters,
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
     * @param \Zavudev\Senders\Agent\Tools\ToolUpdateParams\Parameters|ParametersShape1 $parameters Body param
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
        \Zavudev\Senders\Agent\Tools\ToolUpdateParams\Parameters|array|null $parameters = null,
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
     * Test a tool by triggering its webhook with test parameters.
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
