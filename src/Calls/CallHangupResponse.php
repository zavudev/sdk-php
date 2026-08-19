<?php

declare(strict_types=1);

namespace Zavudev\Calls;

use Zavudev\Calls\CallHangupResponse\Call;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CallShape from \Zavudev\Calls\CallHangupResponse\Call
 *
 * @phpstan-type CallHangupResponseShape = array{call: Call|CallShape}
 */
final class CallHangupResponse implements BaseModel
{
    /** @use SdkModel<CallHangupResponseShape> */
    use SdkModel;

    #[Required]
    public Call $call;

    /**
     * `new CallHangupResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CallHangupResponse::with(call: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CallHangupResponse)->withCall(...)
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
     * @param Call|CallShape $call
     */
    public static function with(Call|array $call): self
    {
        $self = new self;

        $self['call'] = $call;

        return $self;
    }

    /**
     * @param Call|CallShape $call
     */
    public function withCall(Call|array $call): self
    {
        $self = clone $this;
        $self['call'] = $call;

        return $self;
    }
}
