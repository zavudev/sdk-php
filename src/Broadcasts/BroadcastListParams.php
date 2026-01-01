<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List broadcasts for this project.
 *
 * @see Zavudev\Services\BroadcastsService::list()
 *
 * @phpstan-type BroadcastListParamsShape = array{
 *   cursor?: string|null,
 *   limit?: int|null,
 *   status?: null|BroadcastStatus|value-of<BroadcastStatus>,
 * }
 */
final class BroadcastListParams implements BaseModel
{
    /** @use SdkModel<BroadcastListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Current status of the broadcast.
     *
     * @var value-of<BroadcastStatus>|null $status
     */
    #[Optional(enum: BroadcastStatus::class)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BroadcastStatus|value-of<BroadcastStatus>|null $status
     */
    public static function with(
        ?string $cursor = null,
        ?int $limit = null,
        BroadcastStatus|string|null $status = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Current status of the broadcast.
     *
     * @param BroadcastStatus|value-of<BroadcastStatus> $status
     */
    public function withStatus(BroadcastStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
