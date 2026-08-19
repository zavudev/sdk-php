<?php

declare(strict_types=1);

namespace Zavudev\Agents;

use Zavudev\Agents\AgentTestResponse\ExecutedToolCall;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ExecutedToolCallShape from \Zavudev\Agents\AgentTestResponse\ExecutedToolCall
 *
 * @phpstan-type AgentTestResponseShape = array{
 *   error: string|null,
 *   inputTokens: int,
 *   knowledgeChunksUsed: int,
 *   latencyMs: int,
 *   outputTokens: int,
 *   success: bool,
 *   text: string|null,
 *   warnings: list<string>,
 *   executedToolCalls?: list<ExecutedToolCall|ExecutedToolCallShape>|null,
 * }
 */
final class AgentTestResponse implements BaseModel
{
    /** @use SdkModel<AgentTestResponseShape> */
    use SdkModel;

    #[Required]
    public ?string $error;

    #[Required]
    public int $inputTokens;

    /**
     * Knowledge-base chunks retrieved for this message. Zero means the answer was not grounded in your documents.
     */
    #[Required]
    public int $knowledgeChunksUsed;

    #[Required]
    public int $latencyMs;

    #[Required]
    public int $outputTokens;

    #[Required]
    public bool $success;

    /**
     * What the agent would reply.
     */
    #[Required]
    public ?string $text;

    /**
     * Things that are true of this agent but that a dry run cannot prove. Surfaced so a passing dry run is never mistaken for proof that the agent works live.
     *
     * - The agent being disabled.
     * - Enabled tools that were **not offered to the model** here — the model never saw them, so a reply that looks like a lookup was invented. Live conversations on every channel do offer them; running them here would cause real side effects.
     * - An agent whose sender has none of the channels it triggers on, which answers every dry run and no real message.
     * - Contact metadata that exists on a real conversation but not here.
     *
     * @var list<string> $warnings
     */
    #[Required(list: 'string')]
    public array $warnings;

    /**
     * Tools that actually ran, in order, when the request set `executeTools`. Empty on a normal dry run, where nothing is executed. An entry with `ok: false` means the agent saw an error and answered around it, which is what a customer would have received.
     *
     * @var list<ExecutedToolCall>|null $executedToolCalls
     */
    #[Optional(list: ExecutedToolCall::class)]
    public ?array $executedToolCalls;

    /**
     * `new AgentTestResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentTestResponse::with(
     *   error: ...,
     *   inputTokens: ...,
     *   knowledgeChunksUsed: ...,
     *   latencyMs: ...,
     *   outputTokens: ...,
     *   success: ...,
     *   text: ...,
     *   warnings: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentTestResponse)
     *   ->withError(...)
     *   ->withInputTokens(...)
     *   ->withKnowledgeChunksUsed(...)
     *   ->withLatencyMs(...)
     *   ->withOutputTokens(...)
     *   ->withSuccess(...)
     *   ->withText(...)
     *   ->withWarnings(...)
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
     * @param list<string> $warnings
     * @param list<ExecutedToolCall|ExecutedToolCallShape>|null $executedToolCalls
     */
    public static function with(
        ?string $error,
        int $inputTokens,
        int $knowledgeChunksUsed,
        int $latencyMs,
        int $outputTokens,
        bool $success,
        ?string $text,
        array $warnings,
        ?array $executedToolCalls = null,
    ): self {
        $self = new self;

        $self['error'] = $error;
        $self['inputTokens'] = $inputTokens;
        $self['knowledgeChunksUsed'] = $knowledgeChunksUsed;
        $self['latencyMs'] = $latencyMs;
        $self['outputTokens'] = $outputTokens;
        $self['success'] = $success;
        $self['text'] = $text;
        $self['warnings'] = $warnings;

        null !== $executedToolCalls && $self['executedToolCalls'] = $executedToolCalls;

        return $self;
    }

    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * Knowledge-base chunks retrieved for this message. Zero means the answer was not grounded in your documents.
     */
    public function withKnowledgeChunksUsed(int $knowledgeChunksUsed): self
    {
        $self = clone $this;
        $self['knowledgeChunksUsed'] = $knowledgeChunksUsed;

        return $self;
    }

    public function withLatencyMs(int $latencyMs): self
    {
        $self = clone $this;
        $self['latencyMs'] = $latencyMs;

        return $self;
    }

    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    /**
     * What the agent would reply.
     */
    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Things that are true of this agent but that a dry run cannot prove. Surfaced so a passing dry run is never mistaken for proof that the agent works live.
     *
     * - The agent being disabled.
     * - Enabled tools that were **not offered to the model** here — the model never saw them, so a reply that looks like a lookup was invented. Live conversations on every channel do offer them; running them here would cause real side effects.
     * - An agent whose sender has none of the channels it triggers on, which answers every dry run and no real message.
     * - Contact metadata that exists on a real conversation but not here.
     *
     * @param list<string> $warnings
     */
    public function withWarnings(array $warnings): self
    {
        $self = clone $this;
        $self['warnings'] = $warnings;

        return $self;
    }

    /**
     * Tools that actually ran, in order, when the request set `executeTools`. Empty on a normal dry run, where nothing is executed. An entry with `ok: false` means the agent saw an error and answered around it, which is what a customer would have received.
     *
     * @param list<ExecutedToolCall|ExecutedToolCallShape> $executedToolCalls
     */
    public function withExecutedToolCalls(array $executedToolCalls): self
    {
        $self = clone $this;
        $self['executedToolCalls'] = $executedToolCalls;

        return $self;
    }
}
