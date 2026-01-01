<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type AgentExecutionShape = array{
 *   id: string,
 *   agentID: string,
 *   cost: float,
 *   createdAt: \DateTimeInterface,
 *   inputTokens: int,
 *   latencyMs: int,
 *   outputTokens: int,
 *   status: AgentExecutionStatus|value-of<AgentExecutionStatus>,
 *   errorMessage?: string|null,
 *   inboundMessageID?: string|null,
 *   responseMessageID?: string|null,
 *   responseText?: string|null,
 * }
 */
final class AgentExecution implements BaseModel
{
    /** @use SdkModel<AgentExecutionShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('agentId')]
    public string $agentID;

    /**
     * Cost in USD.
     */
    #[Required]
    public float $cost;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public int $inputTokens;

    #[Required]
    public int $latencyMs;

    #[Required]
    public int $outputTokens;

    /**
     * Status of an agent execution.
     *
     * @var value-of<AgentExecutionStatus> $status
     */
    #[Required(enum: AgentExecutionStatus::class)]
    public string $status;

    #[Optional(nullable: true)]
    public ?string $errorMessage;

    #[Optional('inboundMessageId')]
    public ?string $inboundMessageID;

    #[Optional('responseMessageId', nullable: true)]
    public ?string $responseMessageID;

    #[Optional(nullable: true)]
    public ?string $responseText;

    /**
     * `new AgentExecution()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentExecution::with(
     *   id: ...,
     *   agentID: ...,
     *   cost: ...,
     *   createdAt: ...,
     *   inputTokens: ...,
     *   latencyMs: ...,
     *   outputTokens: ...,
     *   status: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentExecution)
     *   ->withID(...)
     *   ->withAgentID(...)
     *   ->withCost(...)
     *   ->withCreatedAt(...)
     *   ->withInputTokens(...)
     *   ->withLatencyMs(...)
     *   ->withOutputTokens(...)
     *   ->withStatus(...)
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
     * @param AgentExecutionStatus|value-of<AgentExecutionStatus> $status
     */
    public static function with(
        string $id,
        string $agentID,
        float $cost,
        \DateTimeInterface $createdAt,
        int $inputTokens,
        int $latencyMs,
        int $outputTokens,
        AgentExecutionStatus|string $status,
        ?string $errorMessage = null,
        ?string $inboundMessageID = null,
        ?string $responseMessageID = null,
        ?string $responseText = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentID'] = $agentID;
        $self['cost'] = $cost;
        $self['createdAt'] = $createdAt;
        $self['inputTokens'] = $inputTokens;
        $self['latencyMs'] = $latencyMs;
        $self['outputTokens'] = $outputTokens;
        $self['status'] = $status;

        null !== $errorMessage && $self['errorMessage'] = $errorMessage;
        null !== $inboundMessageID && $self['inboundMessageID'] = $inboundMessageID;
        null !== $responseMessageID && $self['responseMessageID'] = $responseMessageID;
        null !== $responseText && $self['responseText'] = $responseText;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * Cost in USD.
     */
    public function withCost(float $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

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

    /**
     * Status of an agent execution.
     *
     * @param AgentExecutionStatus|value-of<AgentExecutionStatus> $status
     */
    public function withStatus(AgentExecutionStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withErrorMessage(?string $errorMessage): self
    {
        $self = clone $this;
        $self['errorMessage'] = $errorMessage;

        return $self;
    }

    public function withInboundMessageID(string $inboundMessageID): self
    {
        $self = clone $this;
        $self['inboundMessageID'] = $inboundMessageID;

        return $self;
    }

    public function withResponseMessageID(?string $responseMessageID): self
    {
        $self = clone $this;
        $self['responseMessageID'] = $responseMessageID;

        return $self;
    }

    public function withResponseText(?string $responseText): self
    {
        $self = clone $this;
        $self['responseText'] = $responseText;

        return $self;
    }
}
