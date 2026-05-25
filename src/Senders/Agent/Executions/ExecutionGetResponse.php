<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Executions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\AgentExecution;

/**
 * @phpstan-import-type AgentExecutionShape from \Zavudev\Senders\Agent\AgentExecution
 *
 * @phpstan-type ExecutionGetResponseShape = array{
 *   execution: AgentExecution|AgentExecutionShape
 * }
 */
final class ExecutionGetResponse implements BaseModel
{
    /** @use SdkModel<ExecutionGetResponseShape> */
    use SdkModel;

    #[Required]
    public AgentExecution $execution;

    /**
     * `new ExecutionGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExecutionGetResponse::with(execution: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExecutionGetResponse)->withExecution(...)
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
     * @param AgentExecution|AgentExecutionShape $execution
     */
    public static function with(AgentExecution|array $execution): self
    {
        $self = new self;

        $self['execution'] = $execution;

        return $self;
    }

    /**
     * @param AgentExecution|AgentExecutionShape $execution
     */
    public function withExecution(AgentExecution|array $execution): self
    {
        $self = clone $this;
        $self['execution'] = $execution;

        return $self;
    }
}
