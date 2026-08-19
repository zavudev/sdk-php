<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Agents\AgentCreateParams\Voice;
use Zavudev\Agents\AgentGetResponse;
use Zavudev\Agents\AgentListVoicesResponse;
use Zavudev\Agents\AgentNewResponse;
use Zavudev\Agents\AgentTestParams\History;
use Zavudev\Agents\AgentTestResponse;
use Zavudev\Agents\AgentUpdateResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Agent;
use Zavudev\Senders\Agent\AgentProvider;

/**
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentCreateParams\Voice
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentUpdateParams\Voice as VoiceShape1
 * @phpstan-import-type HistoryShape from \Zavudev\Agents\AgentTestParams\History
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface AgentsContract
{
    /**
     * @api
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
    ): AgentNewResponse;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): AgentGetResponse;

    /**
     * @api
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
    ): AgentUpdateResponse;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $language BCP-47 tag (`en`, `es`, `pt-BR`). Omit, or pass `auto`, for every voice.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listVoices(
        ?string $language = null,
        RequestOptions|array|null $requestOptions = null
    ): AgentListVoicesResponse;

    /**
     * @api
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
    ): AgentTestResponse;
}
