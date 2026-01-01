<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Test a tool by triggering its webhook with test parameters.
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
