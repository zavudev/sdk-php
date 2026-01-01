<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;

interface AgentContract
{
    /**
     * @api
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
    ): AgentResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): AgentResponse;

    /**
     * @api
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
    ): AgentResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @throws APIException
     */
    public function stats(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): AgentStats;
}
