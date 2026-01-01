<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\AgentTool;
use Zavudev\Senders\Agent\Tools\ToolCreateParams;
use Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters\Type;
use Zavudev\Senders\Agent\Tools\ToolDeleteParams;
use Zavudev\Senders\Agent\Tools\ToolGetResponse;
use Zavudev\Senders\Agent\Tools\ToolListParams;
use Zavudev\Senders\Agent\Tools\ToolNewResponse;
use Zavudev\Senders\Agent\Tools\ToolRetrieveParams;
use Zavudev\Senders\Agent\Tools\ToolTestParams;
use Zavudev\Senders\Agent\Tools\ToolTestResponse;
use Zavudev\Senders\Agent\Tools\ToolUpdateParams;
use Zavudev\Senders\Agent\Tools\ToolUpdateResponse;
use Zavudev\ServiceContracts\Senders\Agent\ToolsRawContract;

final class ToolsRawService implements ToolsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new tool for an agent. Tools allow the agent to call external webhooks.
     *
     * @param array{
     *   description: string,
     *   name: string,
     *   parameters: array{
     *     properties: array<string,array{description?: string, type?: string}>,
     *     required: list<string>,
     *     type: 'object'|Type,
     *   },
     *   webhookURL: string,
     *   enabled?: bool,
     *   webhookSecret?: string,
     * }|ToolCreateParams $params
     *
     * @return BaseResponse<ToolNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|ToolCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ToolCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/agent/tools', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: ToolNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get a specific tool.
     *
     * @param array{senderID: string}|ToolRetrieveParams $params
     *
     * @return BaseResponse<ToolGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $toolID,
        array|ToolRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ToolRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/tools/%2$s', $senderID, $toolID],
            options: $options,
            convert: ToolGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a tool.
     *
     * @param string $toolID Path param:
     * @param array{
     *   senderID: string,
     *   description?: string,
     *   enabled?: bool,
     *   name?: string,
     *   parameters?: array{
     *     properties: array<string,array{description?: string, type?: string}>,
     *     required: list<string>,
     *     type: 'object'|ToolUpdateParams\Parameters\Type,
     *   },
     *   webhookSecret?: string|null,
     *   webhookURL?: string,
     * }|ToolUpdateParams $params
     *
     * @return BaseResponse<ToolUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $toolID,
        array|ToolUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ToolUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/senders/%1$s/agent/tools/%2$s', $senderID, $toolID],
            body: (object) array_diff_key($parsed, array_flip(['senderID'])),
            options: $options,
            convert: ToolUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List tools for an agent.
     *
     * @param array{
     *   cursor?: string, enabled?: bool, limit?: int
     * }|ToolListParams $params
     *
     * @return BaseResponse<Cursor<AgentTool>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|ToolListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ToolListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/tools', $senderID],
            query: $parsed,
            options: $options,
            convert: AgentTool::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a tool.
     *
     * @param array{senderID: string}|ToolDeleteParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $toolID,
        array|ToolDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ToolDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/senders/%1$s/agent/tools/%2$s', $senderID, $toolID],
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Test a tool by triggering its webhook with test parameters.
     *
     * @param string $toolID Path param:
     * @param array{
     *   senderID: string, testParams: array<string,mixed>
     * }|ToolTestParams $params
     *
     * @return BaseResponse<ToolTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $toolID,
        array|ToolTestParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ToolTestParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/agent/tools/%2$s/test', $senderID, $toolID],
            body: (object) array_diff_key($parsed, array_flip(['senderID'])),
            options: $options,
            convert: ToolTestResponse::class,
        );
    }
}
