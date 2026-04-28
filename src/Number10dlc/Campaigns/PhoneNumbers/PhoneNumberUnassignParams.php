<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Remove a phone number assignment from a 10DLC campaign.
 *
 * @see Zavudev\Services\Number10dlc\Campaigns\PhoneNumbersService::unassign()
 *
 * @phpstan-type PhoneNumberUnassignParamsShape = array{campaignID: string}
 */
final class PhoneNumberUnassignParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberUnassignParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $campaignID;

    /**
     * `new PhoneNumberUnassignParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberUnassignParams::with(campaignID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberUnassignParams)->withCampaignID(...)
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
    public static function with(string $campaignID): self
    {
        $self = new self;

        $self['campaignID'] = $campaignID;

        return $self;
    }

    public function withCampaignID(string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

        return $self;
    }
}
