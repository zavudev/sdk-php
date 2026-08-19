<?php

declare(strict_types=1);

namespace Zavudev\Agents;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Agent;

/**
 * @phpstan-import-type AgentShape from \Zavudev\Senders\Agent\Agent
 *
 * @phpstan-type AgentNewResponseShape = array{agent: Agent|AgentShape}
 */
final class AgentNewResponse implements BaseModel
{
    /** @use SdkModel<AgentNewResponseShape> */
    use SdkModel;

    /**
     * AI Agent configuration for a sender.
     */
    #[Required]
    public Agent $agent;

    /**
     * `new AgentNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentNewResponse::with(agent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentNewResponse)->withAgent(...)
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
     * @param Agent|AgentShape $agent
     */
    public static function with(Agent|array $agent): self
    {
        $self = new self;

        $self['agent'] = $agent;

        return $self;
    }

    /**
     * AI Agent configuration for a sender.
     *
     * @param Agent|AgentShape $agent
     */
    public function withAgent(Agent|array $agent): self
    {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }
}
