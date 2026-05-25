<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Executions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Fetch full details for one execution — including `errorMessage`, `errorCode`, and `responseText`. Use this to debug failures surfaced by the list endpoint.
 *
 * @see Zavudev\Services\Senders\Agent\ExecutionsService::retrieve()
 *
 * @phpstan-type ExecutionRetrieveParamsShape = array{senderID: string}
 */
final class ExecutionRetrieveParams implements BaseModel
{
    /** @use SdkModel<ExecutionRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    /**
     * `new ExecutionRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExecutionRetrieveParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExecutionRetrieveParams)->withSenderID(...)
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
