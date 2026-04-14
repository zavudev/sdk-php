<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BroadcastShape from \Zavudev\Broadcasts\Broadcast
 *
 * @phpstan-type BroadcastRetryReviewResponseShape = array{
 *   broadcast: Broadcast|BroadcastShape
 * }
 */
final class BroadcastRetryReviewResponse implements BaseModel
{
    /** @use SdkModel<BroadcastRetryReviewResponseShape> */
    use SdkModel;

    #[Required]
    public Broadcast $broadcast;

    /**
     * `new BroadcastRetryReviewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BroadcastRetryReviewResponse::with(broadcast: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BroadcastRetryReviewResponse)->withBroadcast(...)
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
     * @param Broadcast|BroadcastShape $broadcast
     */
    public static function with(Broadcast|array $broadcast): self
    {
        $self = new self;

        $self['broadcast'] = $broadcast;

        return $self;
    }

    /**
     * @param Broadcast|BroadcastShape $broadcast
     */
    public function withBroadcast(Broadcast|array $broadcast): self
    {
        $self = clone $this;
        $self['broadcast'] = $broadcast;

        return $self;
    }
}
