<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AgentFlowShape from \Zavudev\Senders\Agent\Flows\AgentFlow
 *
 * @phpstan-type FlowUpdateResponseShape = array{flow: AgentFlow|AgentFlowShape}
 */
final class FlowUpdateResponse implements BaseModel
{
    /** @use SdkModel<FlowUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public AgentFlow $flow;

    /**
     * `new FlowUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowUpdateResponse::with(flow: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowUpdateResponse)->withFlow(...)
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
     * @param AgentFlow|AgentFlowShape $flow
     */
    public static function with(AgentFlow|array $flow): self
    {
        $self = new self;

        $self['flow'] = $flow;

        return $self;
    }

    /**
     * @param AgentFlow|AgentFlowShape $flow
     */
    public function withFlow(AgentFlow|array $flow): self
    {
        $self = clone $this;
        $self['flow'] = $flow;

        return $self;
    }
}
