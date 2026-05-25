<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Fetch invocation logs for a function. Logs are paginated via `nextToken`. Pass `startTime` / `endTime` (Unix epoch milliseconds) to bound the window, or `filterPattern` to filter messages.
 *
 * @see Zavudev\Services\FunctionsService::tailLogs()
 *
 * @phpstan-type FunctionTailLogsParamsShape = array{
 *   endTime?: int|null,
 *   filterPattern?: string|null,
 *   limit?: int|null,
 *   nextToken?: string|null,
 *   startTime?: int|null,
 * }
 */
final class FunctionTailLogsParams implements BaseModel
{
    /** @use SdkModel<FunctionTailLogsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * End of the log window in Unix epoch milliseconds.
     */
    #[Optional]
    public ?int $endTime;

    #[Optional]
    public ?string $filterPattern;

    #[Optional]
    public ?int $limit;

    #[Optional]
    public ?string $nextToken;

    /**
     * Start of the log window in Unix epoch milliseconds.
     */
    #[Optional]
    public ?int $startTime;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?int $endTime = null,
        ?string $filterPattern = null,
        ?int $limit = null,
        ?string $nextToken = null,
        ?int $startTime = null,
    ): self {
        $self = new self;

        null !== $endTime && $self['endTime'] = $endTime;
        null !== $filterPattern && $self['filterPattern'] = $filterPattern;
        null !== $limit && $self['limit'] = $limit;
        null !== $nextToken && $self['nextToken'] = $nextToken;
        null !== $startTime && $self['startTime'] = $startTime;

        return $self;
    }

    /**
     * End of the log window in Unix epoch milliseconds.
     */
    public function withEndTime(int $endTime): self
    {
        $self = clone $this;
        $self['endTime'] = $endTime;

        return $self;
    }

    public function withFilterPattern(string $filterPattern): self
    {
        $self = clone $this;
        $self['filterPattern'] = $filterPattern;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    public function withNextToken(string $nextToken): self
    {
        $self = clone $this;
        $self['nextToken'] = $nextToken;

        return $self;
    }

    /**
     * Start of the log window in Unix epoch milliseconds.
     */
    public function withStartTime(int $startTime): self
    {
        $self = clone $this;
        $self['startTime'] = $startTime;

        return $self;
    }
}
