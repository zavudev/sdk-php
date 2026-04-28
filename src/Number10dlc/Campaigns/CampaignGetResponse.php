<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TenDlcCampaignShape from \Zavudev\Number10dlc\Campaigns\TenDlcCampaign
 *
 * @phpstan-type CampaignGetResponseShape = array{
 *   campaign: TenDlcCampaign|TenDlcCampaignShape
 * }
 */
final class CampaignGetResponse implements BaseModel
{
    /** @use SdkModel<CampaignGetResponseShape> */
    use SdkModel;

    #[Required]
    public TenDlcCampaign $campaign;

    /**
     * `new CampaignGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignGetResponse::with(campaign: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignGetResponse)->withCampaign(...)
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
     * @param TenDlcCampaign|TenDlcCampaignShape $campaign
     */
    public static function with(TenDlcCampaign|array $campaign): self
    {
        $self = new self;

        $self['campaign'] = $campaign;

        return $self;
    }

    /**
     * @param TenDlcCampaign|TenDlcCampaignShape $campaign
     */
    public function withCampaign(TenDlcCampaign|array $campaign): self
    {
        $self = clone $this;
        $self['campaign'] = $campaign;

        return $self;
    }
}
