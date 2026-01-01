<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Delete a flow. Cannot delete flows with active sessions.
 *
 * @see Zavudev\Services\Senders\Agent\FlowsService::delete()
 *
 * @phpstan-type FlowDeleteParamsShape = array{senderID: string}
 */
final class FlowDeleteParams implements BaseModel
{
    /** @use SdkModel<FlowDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    /**
     * `new FlowDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowDeleteParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowDeleteParams)->withSenderID(...)
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

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
