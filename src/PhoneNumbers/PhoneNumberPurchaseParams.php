<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Purchase an available phone number. The first US phone number is free for each team.
 *
 * @see Zavudev\Services\PhoneNumbersService::purchase()
 *
 * @phpstan-type PhoneNumberPurchaseParamsShape = array{
 *   phoneNumber: string, name?: string|null
 * }
 */
final class PhoneNumberPurchaseParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberPurchaseParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Phone number in E.164 format.
     */
    #[Required]
    public string $phoneNumber;

    /**
     * Optional custom name for the phone number.
     */
    #[Optional]
    public ?string $name;

    /**
     * `new PhoneNumberPurchaseParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberPurchaseParams::with(phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberPurchaseParams)->withPhoneNumber(...)
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
    public static function with(string $phoneNumber, ?string $name = null): self
    {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * Phone number in E.164 format.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * Optional custom name for the phone number.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
