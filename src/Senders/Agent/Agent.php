<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Agent\Stats;

/**
 * AI Agent configuration for a sender.
 *
 * @phpstan-import-type StatsShape from \Zavudev\Senders\Agent\Agent\Stats
 *
 * @phpstan-type AgentShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   enabled: bool,
 *   model: string,
 *   name: string,
 *   provider: AgentProvider|value-of<AgentProvider>,
 *   senderID: string,
 *   systemPrompt: string,
 *   updatedAt: \DateTimeInterface,
 *   contextWindowMessages?: int|null,
 *   includeContactMetadata?: bool|null,
 *   maxTokens?: int|null,
 *   stats?: null|Stats|StatsShape,
 *   temperature?: float|null,
 *   triggerOnChannels?: list<string>|null,
 *   triggerOnMessageTypes?: list<string>|null,
 * }
 */
final class Agent implements BaseModel
{
    /** @use SdkModel<AgentShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Whether the agent is active.
     */
    #[Required]
    public bool $enabled;

    /**
     * Model ID (e.g., gpt-4o-mini, claude-3-5-sonnet).
     */
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

    #[Required('senderId')]
    public string $senderID;

    /**
     * System prompt for the agent.
     */
    #[Required]
    public string $systemPrompt;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * Number of previous messages to include as context.
     */
    #[Optional]
    public ?int $contextWindowMessages;

    /**
     * Whether to include contact metadata in context.
     */
    #[Optional]
    public ?bool $includeContactMetadata;

    /**
     * Maximum tokens for LLM response.
     */
    #[Optional(nullable: true)]
    public ?int $maxTokens;

    #[Optional]
    public ?Stats $stats;

    /**
     * LLM temperature (0-2).
     */
    #[Optional(nullable: true)]
    public ?float $temperature;

    /**
     * Channels that trigger the agent.
     *
     * @var list<string>|null $triggerOnChannels
     */
    #[Optional(list: 'string')]
    public ?array $triggerOnChannels;

    /**
     * Message types that trigger the agent.
     *
     * @var list<string>|null $triggerOnMessageTypes
     */
    #[Optional(list: 'string')]
    public ?array $triggerOnMessageTypes;

    /**
     * `new Agent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Agent::with(
     *   id: ...,
     *   createdAt: ...,
     *   enabled: ...,
     *   model: ...,
     *   name: ...,
     *   provider: ...,
     *   senderID: ...,
     *   systemPrompt: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Agent)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEnabled(...)
     *   ->withModel(...)
     *   ->withName(...)
     *   ->withProvider(...)
     *   ->withSenderID(...)
     *   ->withSystemPrompt(...)
     *   ->withUpdatedAt(...)
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
     * @param Stats|StatsShape|null $stats
     * @param list<string>|null $triggerOnChannels
     * @param list<string>|null $triggerOnMessageTypes
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        bool $enabled,
        string $model,
        string $name,
        AgentProvider|string $provider,
        string $senderID,
        string $systemPrompt,
        \DateTimeInterface $updatedAt,
        ?int $contextWindowMessages = null,
        ?bool $includeContactMetadata = null,
        ?int $maxTokens = null,
        Stats|array|null $stats = null,
        ?float $temperature = null,
        ?array $triggerOnChannels = null,
        ?array $triggerOnMessageTypes = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['enabled'] = $enabled;
        $self['model'] = $model;
        $self['name'] = $name;
        $self['provider'] = $provider;
        $self['senderID'] = $senderID;
        $self['systemPrompt'] = $systemPrompt;
        $self['updatedAt'] = $updatedAt;

        null !== $contextWindowMessages && $self['contextWindowMessages'] = $contextWindowMessages;
        null !== $includeContactMetadata && $self['includeContactMetadata'] = $includeContactMetadata;
        null !== $maxTokens && $self['maxTokens'] = $maxTokens;
        null !== $stats && $self['stats'] = $stats;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $triggerOnChannels && $self['triggerOnChannels'] = $triggerOnChannels;
        null !== $triggerOnMessageTypes && $self['triggerOnMessageTypes'] = $triggerOnMessageTypes;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Whether the agent is active.
     */
    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Model ID (e.g., gpt-4o-mini, claude-3-5-sonnet).
     */
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

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * System prompt for the agent.
     */
    public function withSystemPrompt(string $systemPrompt): self
    {
        $self = clone $this;
        $self['systemPrompt'] = $systemPrompt;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Number of previous messages to include as context.
     */
    public function withContextWindowMessages(int $contextWindowMessages): self
    {
        $self = clone $this;
        $self['contextWindowMessages'] = $contextWindowMessages;

        return $self;
    }

    /**
     * Whether to include contact metadata in context.
     */
    public function withIncludeContactMetadata(
        bool $includeContactMetadata
    ): self {
        $self = clone $this;
        $self['includeContactMetadata'] = $includeContactMetadata;

        return $self;
    }

    /**
     * Maximum tokens for LLM response.
     */
    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * @param Stats|StatsShape $stats
     */
    public function withStats(Stats|array $stats): self
    {
        $self = clone $this;
        $self['stats'] = $stats;

        return $self;
    }

    /**
     * LLM temperature (0-2).
     */
    public function withTemperature(?float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * Channels that trigger the agent.
     *
     * @param list<string> $triggerOnChannels
     */
    public function withTriggerOnChannels(array $triggerOnChannels): self
    {
        $self = clone $this;
        $self['triggerOnChannels'] = $triggerOnChannels;

        return $self;
    }

    /**
     * Message types that trigger the agent.
     *
     * @param list<string> $triggerOnMessageTypes
     */
    public function withTriggerOnMessageTypes(
        array $triggerOnMessageTypes
    ): self {
        $self = clone $this;
        $self['triggerOnMessageTypes'] = $triggerOnMessageTypes;

        return $self;
    }
}
