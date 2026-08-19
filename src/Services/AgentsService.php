<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Agents\AgentCreateParams\Voice;
use Zavudev\Agents\AgentGetResponse;
use Zavudev\Agents\AgentListVoicesResponse;
use Zavudev\Agents\AgentNewResponse;
use Zavudev\Agents\AgentTestParams\History;
use Zavudev\Agents\AgentTestResponse;
use Zavudev\Agents\AgentUpdateResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Agent;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\ServiceContracts\AgentsContract;
use Zavudev\Services\Agents\SendersService;

/**
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentCreateParams\Voice
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentUpdateParams\Voice as VoiceShape1
 * @phpstan-import-type HistoryShape from \Zavudev\Agents\AgentTestParams\History
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AgentsService implements AgentsContract
{
    /**
     * @api
     */
    public AgentsRawService $raw;

    /**
     * @api
     */
    public SendersService $senders;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AgentsRawService($client);
        $this->senders = new SendersService($client);
    }

    /**
     * @api
     *
     * Create an agent without a sender. It is created disabled; connect a sender and enable it when you are ready for it to answer.
     *
     * **Sub-resources.** An agent's tools, flows and knowledge bases are reachable at `/v1/agents/{agentId}/tools`, `/v1/agents/{agentId}/flows` and `/v1/agents/{agentId}/knowledge-bases`, mirroring the sender-scoped routes documented under `/v1/senders/{senderId}/agent/...` exactly. Use the agent-scoped form while the agent has no sender: the sender-scoped one cannot address it.
     *
     * @param AgentProvider|value-of<AgentProvider> $provider LLM provider for the AI agent
     * @param list<string> $triggerOnChannels
     * @param list<string> $triggerOnMessageTypes
     * @param Voice|VoiceShape $voice Voice Agent configuration on a sender's AI agent. Controls how the agent behaves on inbound and outbound phone calls through Zavu's managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling). Requires the Voice Agents feature to be enabled for your team.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $model,
        string $name,
        AgentProvider|string $provider,
        string $systemPrompt,
        int $contextWindowMessages = 10,
        bool $includeContactMetadata = true,
        ?int $maxTokens = null,
        ?float $temperature = null,
        array $triggerOnChannels = ['*'],
        array $triggerOnMessageTypes = ['text'],
        Voice|array|null $voice = null,
        RequestOptions|array|null $requestOptions = null,
    ): AgentNewResponse {
        $params = Util::removeNulls(
            [
                'model' => $model,
                'name' => $name,
                'provider' => $provider,
                'systemPrompt' => $systemPrompt,
                'contextWindowMessages' => $contextWindowMessages,
                'includeContactMetadata' => $includeContactMetadata,
                'maxTokens' => $maxTokens,
                'temperature' => $temperature,
                'triggerOnChannels' => $triggerOnChannels,
                'triggerOnMessageTypes' => $triggerOnMessageTypes,
                'voice' => $voice,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get an agent
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): AgentGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($agentID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update an agent
     *
     * @param string $agentID agent ID
     * @param AgentProvider|value-of<AgentProvider> $provider LLM provider for the AI agent
     * @param list<string> $triggerOnChannels
     * @param list<string> $triggerOnMessageTypes
     * @param \Zavudev\Agents\AgentUpdateParams\Voice|VoiceShape1 $voice Voice Agent configuration. Patch this object to enable voice, change the greeting, or adjust call limits. Requires the Voice Agents feature to be enabled for your team.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $agentID,
        ?string $apiKey = null,
        ?int $contextWindowMessages = null,
        ?bool $enabled = null,
        ?bool $includeContactMetadata = null,
        ?int $maxTokens = null,
        ?string $model = null,
        ?string $name = null,
        AgentProvider|string|null $provider = null,
        ?string $systemPrompt = null,
        ?float $temperature = null,
        ?array $triggerOnChannels = null,
        ?array $triggerOnMessageTypes = null,
        \Zavudev\Agents\AgentUpdateParams\Voice|array|null $voice = null,
        RequestOptions|array|null $requestOptions = null,
    ): AgentUpdateResponse {
        $params = Util::removeNulls(
            [
                'apiKey' => $apiKey,
                'contextWindowMessages' => $contextWindowMessages,
                'enabled' => $enabled,
                'includeContactMetadata' => $includeContactMetadata,
                'maxTokens' => $maxTokens,
                'model' => $model,
                'name' => $name,
                'provider' => $provider,
                'systemPrompt' => $systemPrompt,
                'temperature' => $temperature,
                'triggerOnChannels' => $triggerOnChannels,
                'triggerOnMessageTypes' => $triggerOnMessageTypes,
                'voice' => $voice,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Every agent in the project, newest first — including agents that are not connected to any sender yet, which the sender-scoped routes cannot reach. Each item carries `senderIds`, the senders the agent answers on.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Agent>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete an agent
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($agentID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The voices an agent can speak with, for `voice.ttsVoiceId`. Filter by `language` to get the ones that speak it; a voice can still be used with `language: auto`, where the agent follows the caller and keeps the chosen voice.
     *
     * @param string $language BCP-47 tag (`en`, `es`, `pt-BR`). Omit, or pass `auto`, for every voice.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listVoices(
        ?string $language = null,
        RequestOptions|array|null $requestOptions = null
    ): AgentListVoicesResponse {
        $params = Util::removeNulls(['language' => $language]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listVoices(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Run the agent's prompt, model and knowledge base against a message and return the reply instead of delivering it. Writes nothing and charges nothing, so it is safe to call repeatedly while iterating on a prompt.
     *
     * Note that a dry run never **executes** tools — running them would cause real side effects. Live conversations on every channel do call them. When the agent has enabled tools, that gap is reported in `warnings` rather than silently producing an answer that looks like a tool call happened.
     *
     * @param string $agentID agent ID
     * @param string $message what to say to the agent
     * @param bool $executeTools Run the tools the agent calls instead of reporting the choice and stopping.
     *
     * Off by default because a tool handler talks to the outside world: a rehearsal that charges a card is not a rehearsal. Turn it on to exercise the loop that actually matters — the model picks a tool, the handler answers, the model replies with the result — without sending a message to anyone. What ran comes back in `executedToolCalls`.
     * @param list<History|HistoryShape> $history Prior turns, oldest first, to exercise multi-turn behaviour without persisting a thread. Trimmed to the agent's context window.
     * @param bool $useKnowledgeBase set false to skip retrieval and isolate prompt behaviour from the knowledge base
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $agentID,
        string $message,
        bool $executeTools = false,
        ?array $history = null,
        bool $useKnowledgeBase = true,
        RequestOptions|array|null $requestOptions = null,
    ): AgentTestResponse {
        $params = Util::removeNulls(
            [
                'message' => $message,
                'executeTools' => $executeTools,
                'history' => $history,
                'useKnowledgeBase' => $useKnowledgeBase,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->test($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
