<?php

declare(strict_types=1);

namespace Zavudev\Calls;

use Zavudev\Calls\CallGetResponse\Call;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CallShape from \Zavudev\Calls\CallGetResponse\Call
 *
 * @phpstan-type CallGetResponseShape = array{call: Call|CallShape}
 */
final class CallGetResponse implements BaseModel
{
    /** @use SdkModel<CallGetResponseShape> */
    use SdkModel;

    #[Required]
    public Call $call;

    /**
     * `new CallGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CallGetResponse::with(call: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CallGetResponse)->withCall(...)
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
