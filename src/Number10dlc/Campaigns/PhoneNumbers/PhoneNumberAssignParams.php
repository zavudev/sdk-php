<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Assign a US phone number to an approved 10DLC campaign. The campaign must be in approved status.
 *
 * @see Zavudev\Services\Number10dlc\Campaigns\PhoneNumbersService::assign()
 *
 * @phpstan-type PhoneNumberAssignParamsShape = array{phoneNumberID: string}
 */
final class PhoneNumberAssignParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberAssignParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the phone number to assign.
     */
    #[Required('phoneNumberId')]
    public string $phoneNumberID;

    /**
     * `new PhoneNumberAssignParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberAssignParams::with(phoneNumberID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberAssignParams)->withPhoneNumberID(...)
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
    public static function with(string $phoneNumberID): self
    {
        $self = new self;

        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * ID of the phone number to assign.
     */
    public function withPhoneNumberID(string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }
}
