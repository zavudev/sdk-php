<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Agents\AgentCreateParams;
use Zavudev\Agents\AgentCreateParams\Voice;
use Zavudev\Agents\AgentGetResponse;
use Zavudev\Agents\AgentListParams;
use Zavudev\Agents\AgentListVoicesParams;
use Zavudev\Agents\AgentListVoicesResponse;
use Zavudev\Agents\AgentNewResponse;
use Zavudev\Agents\AgentTestParams;
use Zavudev\Agents\AgentTestParams\History;
use Zavudev\Agents\AgentTestResponse;
use Zavudev\Agents\AgentUpdateParams;
use Zavudev\Agents\AgentUpdateResponse;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Agent;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\ServiceContracts\AgentsRawContract;

/**
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentCreateParams\Voice
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentUpdateParams\Voice as VoiceShape1
 * @phpstan-import-type HistoryShape from \Zavudev\Agents\AgentTestParams\History
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AgentsRawService implements AgentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create an agent without a sender. It is created disabled; connect a sender and enable it when you are ready for it to answer.
     *
     * **Sub-resources.** An agent's tools, flows and knowledge bases are reachable at `/v1/agents/{agentId}/tools`, `/v1/agents/{agentId}/flows` and `/v1/agents/{agentId}/knowledge-bases`, mirroring the sender-scoped routes documented under `/v1/senders/{senderId}/agent/...` exactly. Use the agent-scoped form while the agent has no sender: the sender-scoped one cannot address it.
     *
     * @param array{
     *   model: string,
     *   name: string,
     *   provider: AgentProvider|value-of<AgentProvider>,
     *   systemPrompt: string,
     *   contextWindowMessages?: int,
     *   includeContactMetadata?: bool,
     *   maxTokens?: int,
     *   temperature?: float,
     *   triggerOnChannels?: list<string>,
     *   triggerOnMessageTypes?: list<string>,
     *   voice?: Voice|VoiceShape,
     * }|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/agents',
            body: (object) $parsed,
            options: $options,
            convert: AgentNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get an agent
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/agents/%1$s', $agentID],
            options: $requestOptions,
            convert: AgentGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update an agent
     *
     * @param string $agentID agent ID
     * @param array{
     *   apiKey?: string,
     *   contextWindowMessages?: int,
     *   enabled?: bool,
     *   includeContactMetadata?: bool,
     *   maxTokens?: int|null,
     *   model?: string,
     *   name?: string,
     *   provider?: AgentProvider|value-of<AgentProvider>,
     *   systemPrompt?: string,
     *   temperature?: float|null,
     *   triggerOnChannels?: list<string>,
     *   triggerOnMessageTypes?: list<string>,
     *   voice?: AgentUpdateParams\Voice|VoiceShape1,
     * }|AgentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $agentID,
        array|AgentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/agents/%1$s', $agentID],
            body: (object) $parsed,
            options: $options,
            convert: AgentUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Every agent in the project, newest first — including agents that are not connected to any sender yet, which the sender-scoped routes cannot reach. Each item carries `senderIds`, the senders the agent answers on.
     *
     * @param array{cursor?: string, limit?: int}|AgentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Agent>>
     *
     * @throws APIException
     */
    public function list(
        array|AgentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/agents',
            query: $parsed,
            options: $options,
            convert: Agent::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete an agent
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/agents/%1$s', $agentID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * The voices an agent can speak with, for `voice.ttsVoiceId`. Filter by `language` to get the ones that speak it; a voice can still be used with `language: auto`, where the agent follows the caller and keeps the chosen voice.
     *
     * @param array{language?: string}|AgentListVoicesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentListVoicesResponse>
     *
     * @throws APIException
     */
    public function listVoices(
        array|AgentListVoicesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentListVoicesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/agents/voices',
            query: $parsed,
            options: $options,
            convert: AgentListVoicesResponse::class,
        );
    }

    /**
     * @api
     *
     * Run the agent's prompt, model and knowledge base against a message and return the reply instead of delivering it. Writes nothing and charges nothing, so it is safe to call repeatedly while iterating on a prompt.
     *
     * Note that a dry run never **executes** tools — running them would cause real side effects. Live conversations on every channel do call them. When the agent has enabled tools, that gap is reported in `warnings` rather than silently producing an answer that looks like a tool call happened.
     *
     * @param string $agentID agent ID
     * @param array{
     *   message: string,
     *   executeTools?: bool,
     *   history?: list<History|HistoryShape>,
     *   useKnowledgeBase?: bool,
     * }|AgentTestParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $agentID,
        array|AgentTestParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentTestParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/agents/%1$s/test', $agentID],
            body: (object) $parsed,
            options: $options,
            convert: AgentTestResponse::class,
        );
    }
}
