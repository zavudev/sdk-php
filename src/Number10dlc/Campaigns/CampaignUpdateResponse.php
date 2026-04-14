<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TenDlcCampaignShape from \Zavudev\Number10dlc\Campaigns\TenDlcCampaign
 *
 * @phpstan-type CampaignUpdateResponseShape = array{
 *   campaign: TenDlcCampaign|TenDlcCampaignShape
 * }
 */
final class CampaignUpdateResponse implements BaseModel
{
    /** @use SdkModel<CampaignUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public TenDlcCampaign $campaign;

    /**
     * `new CampaignUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignUpdateResponse::with(campaign: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignUpdateResponse)->withCampaign(...)
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
