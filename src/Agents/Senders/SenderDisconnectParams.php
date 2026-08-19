<?php

declare(strict_types=1);

namespace Zavudev\Agents\Senders;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Stop the agent answering on this sender. The agent's primary sender is part of the agent itself and cannot be disconnected here.
 *
 * @see Zavudev\Services\Agents\SendersService::disconnect()
 *
 * @phpstan-type SenderDisconnectParamsShape = array{agentID: string}
 */
final class SenderDisconnectParams implements BaseModel
{
    /** @use SdkModel<SenderDisconnectParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $agentID;

    /**
     * `new SenderDisconnectParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderDisconnectParams::with(agentID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderDisconnectParams)->withAgentID(...)
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
     */
    public static function with(string $agentID): self
    {
        $self = new self;

        $self['agentID'] = $agentID;

        return $self;
    }

    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }
}
