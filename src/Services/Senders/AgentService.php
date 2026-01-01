<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;
use Zavudev\ServiceContracts\Senders\AgentContract;
use Zavudev\Services\Senders\Agent\ExecutionsService;
use Zavudev\Services\Senders\Agent\FlowsService;
use Zavudev\Services\Senders\Agent\KnowledgeBasesService;
use Zavudev\Services\Senders\Agent\ToolsService;

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
     * @param 'openai'|'anthropic'|'google'|'mistral'|'zavu'|AgentProvider $provider LLM provider for the AI agent
     * @param string $apiKey API key for the LLM provider. Required unless provider is 'zavu'.
     * @param list<string> $triggerOnChannels
     * @param list<string> $triggerOnMessageTypes
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $model,
        string $name,
        string|AgentProvider $provider,
        string $systemPrompt,
        ?string $apiKey = null,
        int $contextWindowMessages = 10,
        bool $includeContactMetadata = true,
        ?int $maxTokens = null,
        ?float $temperature = null,
        array $triggerOnChannels = ['*'],
        array $triggerOnMessageTypes = ['text'],
        ?RequestOptions $requestOptions = null,
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
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        ?RequestOptions $requestOptions = null
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
     * @param 'openai'|'anthropic'|'google'|'mistral'|'zavu'|AgentProvider $provider LLM provider for the AI agent
     * @param list<string> $triggerOnChannels
     * @param list<string> $triggerOnMessageTypes
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
        string|AgentProvider|null $provider = null,
        ?string $systemPrompt = null,
        ?float $temperature = null,
        ?array $triggerOnChannels = null,
        ?array $triggerOnMessageTypes = null,
        ?RequestOptions $requestOptions = null,
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
     * @throws APIException
     */
    public function delete(
        string $senderID,
        ?RequestOptions $requestOptions = null
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
     * @throws APIException
     */
    public function stats(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): AgentStats {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->stats($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
