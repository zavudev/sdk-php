<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List 10DLC campaign registrations for this project.
 *
 * @see Zavudev\Services\Number10dlc\CampaignsService::list()
 *
 * @phpstan-type CampaignListParamsShape = array{
 *   brandID?: string|null, cursor?: string|null, limit?: int|null
 * }
 */
final class CampaignListParams implements BaseModel
{
    /** @use SdkModel<CampaignListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filter campaigns by brand ID.
     */
    #[Optional]
    public ?string $brandID;

    #[Optional]
    public ?string $cursor;

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
        ?string $brandID = null,
        ?string $cursor = null,
        ?int $limit = null
    ): self {
        $self = new self;

        null !== $brandID && $self['brandID'] = $brandID;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Filter campaigns by brand ID.
     */
    public function withBrandID(string $brandID): self
    {
        $self = clone $this;
        $self['brandID'] = $brandID;

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
}
