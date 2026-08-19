<?php

declare(strict_types=1);

namespace Zavudev\URLs;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Request manual review of a rejected URL. Only URLs in 'rejected' status can be escalated; the status then moves to 'escalated'.
 *
 * @see Zavudev\Services\URLsService::escalate()
 *
 * @phpstan-type URLEscalateParamsShape = array{reason: string}
 */
final class URLEscalateParams implements BaseModel
{
    /** @use SdkModel<URLEscalateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Why the URL should be reviewed manually.
     */
    #[Required]
    public string $reason;

    /**
     * `new URLEscalateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * URLEscalateParams::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new URLEscalateParams)->withReason(...)
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
    public static function with(string $reason): self
    {
        $self = new self;

        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the URL should be reviewed manually.
     */
    public function withReason(string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }
}
