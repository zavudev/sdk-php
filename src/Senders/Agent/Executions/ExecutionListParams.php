<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Executions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\AgentExecutionStatus;

/**
 * List recent agent executions with pagination.
 *
 * @see Zavudev\Services\Senders\Agent\ExecutionsService::list()
 *
 * @phpstan-type ExecutionListParamsShape = array{
 *   cursor?: string|null,
 *   limit?: int|null,
 *   status?: null|AgentExecutionStatus|value-of<AgentExecutionStatus>,
 * }
 */
final class ExecutionListParams implements BaseModel
{
    /** @use SdkModel<ExecutionListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Status of an agent execution.
     *
     * @var value-of<AgentExecutionStatus>|null $status
     */
    #[Optional(enum: AgentExecutionStatus::class)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AgentExecutionStatus|value-of<AgentExecutionStatus>|null $status
     */
    public static function with(
        ?string $cursor = null,
        ?int $limit = null,
        AgentExecutionStatus|string|null $status = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
}
