<?php

declare(strict_types=1);

namespace Zavudev\Agents\Senders;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Make the agent answer on this sender. An agent can serve several senders; a sender answers with at most one agent, so connecting one that is already in use returns `400` naming the agent that holds it.
 *
 * @see Zavudev\Services\Agents\SendersService::connect()
 *
 * @phpstan-type SenderConnectParamsShape = array{senderID: string}
 */
final class SenderConnectParams implements BaseModel
{
    /** @use SdkModel<SenderConnectParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Sender to connect.
     */
    #[Required('senderId')]
    public string $senderID;

    /**
     * `new SenderConnectParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SenderConnectParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SenderConnectParams)->withSenderID(...)
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
    public static function with(string $senderID): self
    {
        $self = new self;

        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Sender to connect.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
