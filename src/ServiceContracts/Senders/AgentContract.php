<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentCreateParams\Voice;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;

/**
 * @phpstan-import-type VoiceShape from \Zavudev\Senders\Agent\AgentCreateParams\Voice
 * @phpstan-import-type VoiceShape from \Zavudev\Senders\Agent\AgentUpdateParams\Voice as VoiceShape1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface AgentContract
{
    /**
     * @api
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
    ): AgentResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): AgentResponse;

    /**
     * @api
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
    ): AgentResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function stats(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): AgentStats;
}
