<?php

declare(strict_types=1);

namespace Zavudev\Agents;

use Zavudev\Agents\AgentTestParams\History;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Run the agent's prompt, model and knowledge base against a message and return the reply instead of delivering it. Writes nothing and charges nothing, so it is safe to call repeatedly while iterating on a prompt.
 *
 * Note that a dry run never **executes** tools — running them would cause real side effects. Live conversations on every channel do call them. When the agent has enabled tools, that gap is reported in `warnings` rather than silently producing an answer that looks like a tool call happened.
 *
 * @see Zavudev\Services\AgentsService::test()
 *
 * @phpstan-import-type HistoryShape from \Zavudev\Agents\AgentTestParams\History
 *
 * @phpstan-type AgentTestParamsShape = array{
 *   message: string,
 *   executeTools?: bool|null,
 *   history?: list<History|HistoryShape>|null,
 *   useKnowledgeBase?: bool|null,
 * }
 */
final class AgentTestParams implements BaseModel
{
    /** @use SdkModel<AgentTestParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * What to say to the agent.
     */
    #[Required]
    public string $message;

    /**
     * Run the tools the agent calls instead of reporting the choice and stopping.
     *
     * Off by default because a tool handler talks to the outside world: a rehearsal that charges a card is not a rehearsal. Turn it on to exercise the loop that actually matters — the model picks a tool, the handler answers, the model replies with the result — without sending a message to anyone. What ran comes back in `executedToolCalls`.
     */
    #[Optional]
    public ?bool $executeTools;

    /**
     * Prior turns, oldest first, to exercise multi-turn behaviour without persisting a thread. Trimmed to the agent's context window.
     *
     * @var list<History>|null $history
     */
    #[Optional(list: History::class)]
    public ?array $history;

    /**
     * Set false to skip retrieval and isolate prompt behaviour from the knowledge base.
     */
    #[Optional]
    public ?bool $useKnowledgeBase;

    /**
     * `new AgentTestParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentTestParams::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentTestParams)->withMessage(...)
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
     * @param list<History|HistoryShape>|null $history
     */
    public static function with(
        string $message,
        ?bool $executeTools = null,
        ?array $history = null,
        ?bool $useKnowledgeBase = null,
    ): self {
        $self = new self;

        $self['message'] = $message;

        null !== $executeTools && $self['executeTools'] = $executeTools;
        null !== $history && $self['history'] = $history;
        null !== $useKnowledgeBase && $self['useKnowledgeBase'] = $useKnowledgeBase;

        return $self;
    }

    /**
     * What to say to the agent.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Run the tools the agent calls instead of reporting the choice and stopping.
     *
     * Off by default because a tool handler talks to the outside world: a rehearsal that charges a card is not a rehearsal. Turn it on to exercise the loop that actually matters — the model picks a tool, the handler answers, the model replies with the result — without sending a message to anyone. What ran comes back in `executedToolCalls`.
     */
    public function withExecuteTools(bool $executeTools): self
    {
        $self = clone $this;
        $self['executeTools'] = $executeTools;

        return $self;
    }

    /**
     * Prior turns, oldest first, to exercise multi-turn behaviour without persisting a thread. Trimmed to the agent's context window.
     *
     * @param list<History|HistoryShape> $history
     */
    public function withHistory(array $history): self
    {
        $self = clone $this;
        $self['history'] = $history;

        return $self;
    }

    /**
     * Set false to skip retrieval and isolate prompt behaviour from the knowledge base.
     */
    public function withUseKnowledgeBase(bool $useKnowledgeBase): self
    {
        $self = clone $this;
        $self['useKnowledgeBase'] = $useKnowledgeBase;

        return $self;
    }
}
