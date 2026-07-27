<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentCreateParams\Voice;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;
use Zavudev\ServiceContracts\Senders\AgentContract;
use Zavudev\Services\Senders\Agent\ExecutionsService;
use Zavudev\Services\Senders\Agent\FlowsService;
use Zavudev\Services\Senders\Agent\KnowledgeBasesService;
use Zavudev\Services\Senders\Agent\ToolsService;

/**
 * @phpstan-import-type VoiceShape from \Zavudev\Senders\Agent\AgentCreateParams\Voice
 * @phpstan-import-type VoiceShape from \Zavudev\Senders\Agent\AgentUpdateParams\Voice as VoiceShape1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AgentService implements AgentContract
{
    /**
     * @api
     */
    public AgentRawService $raw;

    /**
     * @api
     */
    public ExecutionsService $executions;

    /**
     * @api
     */
    public FlowsService $flows;

    /**
     * @api
     */
    public ToolsService $tools;

    /**
     * @api
     */
    public KnowledgeBasesService $knowledgeBases;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AgentRawService($client);
        $this->executions = new ExecutionsService($client);
        $this->flows = new FlowsService($client);
        $this->tools = new ToolsService($client);
        $this->knowledgeBases = new KnowledgeBasesService($client);
    }

    /**
     * @api
     *
     * Create an AI agent for a sender. Each sender can have at most one agent.
     *
     * @param AgentProvider|value-of<AgentProvider> $provider LLM provider for the AI agent
     * @param string $apiKey API key for the LLM provider. Required unless provider is 'zavu'.
     * @param list<string> $triggerOnChannels
     * @param list<string> $triggerOnMessageTypes
     * @param Voice|VoiceShape $voice Voice Agent configuration. Enable this to let the agent answer and place phone calls with Zavu's managed voice pipeline. Requires the Voice Agents feature to be enabled for your team.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $model,
        string $name,
        AgentProvider|string $provider,
        string $systemPrompt,
        ?string $apiKey = null,
        int $contextWindowMessages = 10,
        bool $includeContactMetadata = true,
        ?int $maxTokens = null,
        ?float $temperature = null,
        array $triggerOnChannels = ['*'],
        array $triggerOnMessageTypes = ['text'],
        Voice|array|null $voice = null,
        RequestOptions|array|null $requestOptions = null,
    ): AgentResponse {
        $params = Util::removeNulls(
            [
                'model' => $model,
                'name' => $name,
                'provider' => $provider,
                'systemPrompt' => $systemPrompt,
                'apiKey' => $apiKey,
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
        $response = $this->raw->create($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get the AI agent configuration for a sender.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): AgentResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update an AI agent's configuration.
     *
     * @param AgentProvider|value-of<AgentProvider> $provider LLM provider for the AI agent
     * @param list<string> $triggerOnChannels
     * @param list<string> $triggerOnMessageTypes
     * @param \Zavudev\Senders\Agent\AgentUpdateParams\Voice|VoiceShape1 $voice Voice Agent configuration. Patch this object to enable voice, change the greeting, or adjust call limits. Requires the Voice Agents feature to be enabled for your team.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
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
        \Zavudev\Senders\Agent\AgentUpdateParams\Voice|array|null $voice = null,
        RequestOptions|array|null $requestOptions = null,
    ): AgentResponse {
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
        $response = $this->raw->update($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete an AI agent.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get statistics for an AI agent including invocations, tokens, and costs.
     *
     * Covers the messaging channels only. Voice calls are not counted here: a call is a multi-turn conversation rather than one inbound message and one reply, so it is recorded as a call, not an execution. An agent that only answers phone calls reports zeros on every field. Use `GET /v1/calls` for voice activity, duration, and cost.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function stats(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): AgentStats {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->stats($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
