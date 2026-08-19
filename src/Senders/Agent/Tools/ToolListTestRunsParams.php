<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Recent runs of this tool triggered from the test endpoint, newest first. Covers manual tests only: a tool called by an agent during a real conversation is not recorded here.
 *
 * @see Zavudev\Services\Senders\Agent\ToolsService::listTestRuns()
 *
 * @phpstan-type ToolListTestRunsParamsShape = array{
 *   senderID: string, limit?: int|null
 * }
 */
final class ToolListTestRunsParams implements BaseModel
{
    /** @use SdkModel<ToolListTestRunsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Optional]
    public ?int $limit;

    /**
     * `new ToolListTestRunsParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolListTestRunsParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolListTestRunsParams)->withSenderID(...)
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
    public static function with(string $senderID, ?int $limit = null): self
    {
        $self = new self;

        $self['senderID'] = $senderID;

        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
