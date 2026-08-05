<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Run a tool with the parameters you supply and return what it answered.
 *
 * The call is synchronous: the response carries the tool's status, body, and duration, so a green result is evidence the tool ran rather than evidence it was accepted. Each run is also recorded and readable afterwards via `GET /v1/senders/{senderId}/agent/tools/{toolId}/test-runs`.
 *
 * A tool that answers with an error is reported as a run with `success: false` — the endpoint itself still returns 200. This fires the tool's real webhook, so a test has whatever side effects the tool has.
 *
 * @see Zavudev\Services\Senders\Agent\ToolsService::test()
 *
 * @phpstan-type ToolTestParamsShape = array{
 *   senderID: string, testParams: array<string,mixed>
 * }
 */
final class ToolTestParams implements BaseModel
{
    /** @use SdkModel<ToolTestParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    /**
     * Parameters to pass to the tool for testing.
     *
     * @var array<string,mixed> $testParams
     */
    #[Required(map: 'mixed')]
    public array $testParams;

    /**
     * `new ToolTestParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolTestParams::with(senderID: ..., testParams: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolTestParams)->withSenderID(...)->withTestParams(...)
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
     * @param array<string,mixed> $testParams
     */
    public static function with(string $senderID, array $testParams): self
    {
        $self = new self;

        $self['senderID'] = $senderID;
        $self['testParams'] = $testParams;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Parameters to pass to the tool for testing.
     *
     * @param array<string,mixed> $testParams
     */
    public function withTestParams(array $testParams): self
    {
        $self = clone $this;
        $self['testParams'] = $testParams;

        return $self;
    }
}
