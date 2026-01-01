<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ToolTestResponseShape = array{scheduled: bool}
 */
final class ToolTestResponse implements BaseModel
{
    /** @use SdkModel<ToolTestResponseShape> */
    use SdkModel;

    #[Required]
    public bool $scheduled;

    /**
     * `new ToolTestResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolTestResponse::with(scheduled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolTestResponse)->withScheduled(...)
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
    public static function with(bool $scheduled): self
    {
        $self = new self;

        $self['scheduled'] = $scheduled;

        return $self;
    }

    public function withScheduled(bool $scheduled): self
    {
        $self = clone $this;
        $self['scheduled'] = $scheduled;

        return $self;
    }
}
