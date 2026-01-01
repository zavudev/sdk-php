<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List flows for an agent.
 *
 * @see Zavudev\Services\Senders\Agent\FlowsService::list()
 *
 * @phpstan-type FlowListParamsShape = array{
 *   cursor?: string|null, enabled?: bool|null, limit?: int|null
 * }
 */
final class FlowListParams implements BaseModel
{
    /** @use SdkModel<FlowListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?bool $enabled;

    #[Optional]
    public ?int $limit;

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
        ?string $cursor = null,
        ?bool $enabled = null,
        ?int $limit = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
