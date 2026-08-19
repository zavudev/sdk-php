<?php

declare(strict_types=1);

namespace Zavudev\Agents;

use Zavudev\Agents\AgentCreateParams\Voice;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\AgentProvider;

/**
 * Create an agent without a sender. It is created disabled; connect a sender and enable it when you are ready for it to answer.
 *
 * **Sub-resources.** An agent's tools, flows and knowledge bases are reachable at `/v1/agents/{agentId}/tools`, `/v1/agents/{agentId}/flows` and `/v1/agents/{agentId}/knowledge-bases`, mirroring the sender-scoped routes documented under `/v1/senders/{senderId}/agent/...` exactly. Use the agent-scoped form while the agent has no sender: the sender-scoped one cannot address it.
 *
 * @see Zavudev\Services\AgentsService::create()
 *
 * @phpstan-import-type VoiceShape from \Zavudev\Agents\AgentCreateParams\Voice
 *
 * @phpstan-type AgentCreateParamsShape = array{
 *   model: string,
 *   name: string,
 *   provider: AgentProvider|value-of<AgentProvider>,
 *   systemPrompt: string,
 *   contextWindowMessages?: int|null,
 *   includeContactMetadata?: bool|null,
 *   maxTokens?: int|null,
 *   temperature?: float|null,
 *   triggerOnChannels?: list<string>|null,
 *   triggerOnMessageTypes?: list<string>|null,
 *   voice?: null|Voice|VoiceShape,
 * }
 */
final class AgentCreateParams implements BaseModel
{
    /** @use SdkModel<AgentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $model;

    #[Required]
    public string $name;

    /**
     * LLM provider for the AI agent.
     *
     * @var value-of<AgentProvider> $provider
     */
    #[Required(enum: AgentProvider::class)]
    public string $provider;

    #[Required]
    public string $systemPrompt;

    #[Optional]
    public ?int $contextWindowMessages;

    #[Optional]
    public ?bool $includeContactMetadata;

    #[Optional]
    public ?int $maxTokens;

    #[Optional]
    public ?float $temperature;

    /** @var list<string>|null $triggerOnChannels */
    #[Optional(list: 'string')]
    public ?array $triggerOnChannels;

    /** @var list<string>|null $triggerOnMessageTypes */
    #[Optional(list: 'string')]
    public ?array $triggerOnMessageTypes;

    /**
     * Voice Agent configuration on a sender's AI agent. Controls how the agent behaves on inbound and outbound phone calls through Zavu's managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling). Requires the Voice Agents feature to be enabled for your team.
     */
    #[Optional]
    public ?Voice $voice;

    /**
     * `new AgentCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentCreateParams::with(model: ..., name: ..., provider: ..., systemPrompt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentCreateParams)
     *   ->withModel(...)
     *   ->withName(...)
     *   ->withProvider(...)
     *   ->withSystemPrompt(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AgentProvider|value-of<AgentProvider> $provider
     * @param list<string>|null $triggerOnChannels
     * @param list<string>|null $triggerOnMessageTypes
     * @param Voice|VoiceShape|null $voice
     */
    public static function with(
        string $model,
        string $name,
        AgentProvider|string $provider,
        string $systemPrompt,
        ?int $contextWindowMessages = null,
        ?bool $includeContactMetadata = null,
        ?int $maxTokens = null,
        ?float $temperature = null,
        ?array $triggerOnChannels = null,
        ?array $triggerOnMessageTypes = null,
        Voice|array|null $voice = null,
    ): self {
        $self = new self;

        $self['model'] = $model;
        $self['name'] = $name;
        $self['provider'] = $provider;
        $self['systemPrompt'] = $systemPrompt;

        null !== $contextWindowMessages && $self['contextWindowMessages'] = $contextWindowMessages;
        null !== $includeContactMetadata && $self['includeContactMetadata'] = $includeContactMetadata;
        null !== $maxTokens && $self['maxTokens'] = $maxTokens;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $triggerOnChannels && $self['triggerOnChannels'] = $triggerOnChannels;
        null !== $triggerOnMessageTypes && $self['triggerOnMessageTypes'] = $triggerOnMessageTypes;
        null !== $voice && $self['voice'] = $voice;

        return $self;
    }

    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * LLM provider for the AI agent.
     *
     * @param AgentProvider|value-of<AgentProvider> $provider
     */
    public function withProvider(AgentProvider|string $provider): self
    {
        $self = clone $this;
        $self['provider'] = $provider;

        return $self;
    }

    public function withSystemPrompt(string $systemPrompt): self
    {
        $self = clone $this;
        $self['systemPrompt'] = $systemPrompt;

        return $self;
    }

    public function withContextWindowMessages(int $contextWindowMessages): self
    {
        $self = clone $this;
        $self['contextWindowMessages'] = $contextWindowMessages;

        return $self;
    }

    public function withIncludeContactMetadata(
        bool $includeContactMetadata
    ): self {
        $self = clone $this;
        $self['includeContactMetadata'] = $includeContactMetadata;

        return $self;
    }

    public function withMaxTokens(int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    public function withTemperature(float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * @param list<string> $triggerOnChannels
     */
    public function withTriggerOnChannels(array $triggerOnChannels): self
    {
        $self = clone $this;
        $self['triggerOnChannels'] = $triggerOnChannels;

        return $self;
    }

    /**
     * @param list<string> $triggerOnMessageTypes
     */
    public function withTriggerOnMessageTypes(
        array $triggerOnMessageTypes
    ): self {
        $self = clone $this;
        $self['triggerOnMessageTypes'] = $triggerOnMessageTypes;

        return $self;
    }

    /**
     * Voice Agent configuration on a sender's AI agent. Controls how the agent behaves on inbound and outbound phone calls through Zavu's managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling). Requires the Voice Agents feature to be enabled for your team.
     *
     * @param Voice|VoiceShape $voice
     */
    public function withVoice(Voice|array $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }
}
