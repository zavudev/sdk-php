<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AgentShape from \Zavudev\Senders\Agent\Agent
 *
 * @phpstan-type AgentResponseShape = array{agent: Agent|AgentShape}
 */
final class AgentResponse implements BaseModel
{
    /** @use SdkModel<AgentResponseShape> */
    use SdkModel;

    /**
     * AI Agent configuration for a sender.
     */
    #[Required]
    public Agent $agent;

    /**
     * `new AgentResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentResponse::with(agent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentResponse)->withAgent(...)
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
