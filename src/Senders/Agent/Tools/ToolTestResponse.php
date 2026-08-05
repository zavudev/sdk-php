<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\Tools\ToolTestResponse\Run;

/**
 * @phpstan-import-type RunShape from \Zavudev\Senders\Agent\Tools\ToolTestResponse\Run
 *
 * @phpstan-type ToolTestResponseShape = array{run: Run|RunShape}
 */
final class ToolTestResponse implements BaseModel
{
    /** @use SdkModel<ToolTestResponseShape> */
    use SdkModel;

    /**
     * One run of a tool triggered from the test endpoint. Recorded so a test is verifiable after the fact rather than only visible in the response.
     */
    #[Required]
    public Run $run;

    /**
     * `new ToolTestResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolTestResponse::with(run: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolTestResponse)->withRun(...)
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
     * @param Run|RunShape $run
     */
    public static function with(Run|array $run): self
    {
        $self = new self;

        $self['run'] = $run;

        return $self;
    }

    /**
     * One run of a tool triggered from the test endpoint. Recorded so a test is verifiable after the fact rather than only visible in the response.
     *
     * @param Run|RunShape $run
     */
    public function withRun(Run|array $run): self
    {
        $self = clone $this;
        $self['run'] = $run;

        return $self;
    }
}
