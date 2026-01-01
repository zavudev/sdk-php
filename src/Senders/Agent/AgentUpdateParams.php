<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update an AI agent's configuration.
 *
 * @see Zavudev\Services\Senders\AgentService::update()
 *
 * @phpstan-type AgentUpdateParamsShape = array{
 *   apiKey?: string|null,
 *   contextWindowMessages?: int|null,
 *   enabled?: bool|null,
 *   includeContactMetadata?: bool|null,
 *   maxTokens?: int|null,
 *   model?: string|null,
 *   name?: string|null,
 *   provider?: null|AgentProvider|value-of<AgentProvider>,
 *   systemPrompt?: string|null,
 *   temperature?: float|null,
 *   triggerOnChannels?: list<string>|null,
 *   triggerOnMessageTypes?: list<string>|null,
 * }
 */
final class AgentUpdateParams implements BaseModel
{
    /** @use SdkModel<AgentUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $apiKey;

    #[Optional]
    public ?int $contextWindowMessages;

    #[Optional]
    public ?bool $enabled;

    #[Optional]
    public ?bool $includeContactMetadata;

    #[Optional(nullable: true)]
    public ?int $maxTokens;

    #[Optional]
    public ?string $model;

    #[Optional]
    public ?string $name;

    /**
     * LLM provider for the AI agent.
     *
     * @var value-of<AgentProvider>|null $provider
     */
    #[Optional(enum: AgentProvider::class)]
    public ?string $provider;

    #[Optional]
    public ?string $systemPrompt;

    #[Optional(nullable: true)]
    public ?float $temperature;

    /** @var list<string>|null $triggerOnChannels */
    #[Optional(list: 'string')]
    public ?array $triggerOnChannels;

    /** @var list<string>|null $triggerOnMessageTypes */
    #[Optional(list: 'string')]
    public ?array $triggerOnMessageTypes;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AgentProvider|value-of<AgentProvider>|null $provider
     * @param list<string>|null $triggerOnChannels
     * @param list<string>|null $triggerOnMessageTypes
     */
    public static function with(
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
    ): self {
        $self = new self;

        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $contextWindowMessages && $self['contextWindowMessages'] = $contextWindowMessages;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $includeContactMetadata && $self['includeContactMetadata'] = $includeContactMetadata;
        null !== $maxTokens && $self['maxTokens'] = $maxTokens;
        null !== $model && $self['model'] = $model;
        null !== $name && $self['name'] = $name;
        null !== $provider && $self['provider'] = $provider;
        null !== $systemPrompt && $self['systemPrompt'] = $systemPrompt;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $triggerOnChannels && $self['triggerOnChannels'] = $triggerOnChannels;
        null !== $triggerOnMessageTypes && $self['triggerOnMessageTypes'] = $triggerOnMessageTypes;

        return $self;
    }

    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    public function withContextWindowMessages(int $contextWindowMessages): self
    {
        $self = clone $this;
        $self['contextWindowMessages'] = $contextWindowMessages;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    public function withIncludeContactMetadata(
        bool $includeContactMetadata
    ): self {
        $self = clone $this;
        $self['includeContactMetadata'] = $includeContactMetadata;

        return $self;
    }

    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

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

    public function withTemperature(?float $temperature): self
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
}
